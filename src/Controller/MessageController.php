<?php

namespace App\Controller;

use App\Entity\Message;
use App\Form\MessageType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MessageController extends AbstractController
{
    #[Route('/message', name: 'message')]
    public function index(Request $request)
    {
        // Create a new Message entity
        $message = new Message();

        // Create the form for submitting a new message
        $form = $this->createForm(MessageType::class, $message);

        // Handle form submission
        $form->handleRequest($request);

        // If the form is submitted and valid, save the message to the database
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($message);
            $entityManager->flush();

            // Redirect to the same page to avoid form resubmission
            return $this->redirectToRoute('message');
        }

        // Fetch all existing messages from the database
        $messages = $this->getDoctrine()->getRepository(Message::class)->findAll();

        // Render the template with the form and messages
        return $this->render('message/index.html.twig', [
            'form' => $form->createView(),
            'messages' => $messages,
        ]);
    }
    //Deleting a message
    #[Route("/message/{id}/delete", name: "delete_message")]
    public function delete(Message $message, Request $request, EntityManagerInterface $manager): Response

    {

        if($request->isMethod("POST")){
            $manager->remove($message);
            $manager->flush();
            $this->addFlash("notice", "Message deleted successfully!");
            return $this->redirectToRoute('message_index');
        }


       return $this->render('messages/delete.html.twig', ["id"=>$message->getId(), "message"=>$message]);
    }
}