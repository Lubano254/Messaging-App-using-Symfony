<?php


namespace App\Form;

use App\Entity\Message;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MessageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // Add form fields for the Message entity
        $builder
            ->add('title', TextType::class, [
                'label' => 'Title',
                'attr' => ['placeholder' => 'Enter title']
            ])
            ->add('message', TextareaType::class, [
                'label' => 'Message',
                'attr' => ['placeholder' => 'Enter message']
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Send Message'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        // Associate this form with the Message entity
        $resolver->setDefaults([
            'data_class' => Message::class,
        ]);
    }
}
