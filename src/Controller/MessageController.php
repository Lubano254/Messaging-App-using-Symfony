<?php

namespace App\Controller;

use App\Entity\Message;
use App\Form\MessageType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;

class MessageController extends AbstractController
{
    private $doctrine;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    #[Route('/', name: 'message')]
    public function index(Request $request): Response
    {
        // Create a new Message entity
        $message = new Message();

        // Create the form for submitting a new message
        $form = $this->createForm(MessageType::class, $message);

        // Handle form submission
        $form->handleRequest($request);

        // If the form is submitted and valid, save the message to the database
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->doctrine->getManager();
            $entityManager->persist($message);
            $entityManager->flush();

            $this->addFlash('notice', 'Message created successfully!');

            // Redirect to the same page to avoid form resubmission
            return $this->redirectToRoute('message');
        }

        // Fetch all existing messages from the database
        $messages = $this->doctrine->getRepository(Message::class)->findAll();

        // Render the template with the form and messages
        return $this->render('message/index.html.twig', [
            'form' => $form->createView(),
            'messages' => $messages,
        ]);
    }

    // Show message details
    #[Route('/message/{id}', name: 'message_details')]
    public function details($id): Response
    {
        // Fetch the message by its ID
        $message = $this->doctrine->getRepository(Message::class)->find($id);

        // Check if the message exists
        if (!$message) {
            throw $this->createNotFoundException('Message not found');
        }

        // Render the message details page
        return $this->render('message/details.html.twig', [
            'message' => $message,
        ]);
    }

    #[Route('/message/{id}/delete', name: 'delete_message')]
    public function delete(Message $message, Request $request, EntityManagerInterface $manager): Response
    {
        $manager->remove($message);
        $manager->flush();
        $this->addFlash('notice', 'Message deleted successfully!');

        return $this->redirectToRoute('message');
    }
}
