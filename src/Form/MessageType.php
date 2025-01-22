<?php

namespace App\Form;

use App\Entity\Message;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class MessageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // Add form fields for the Message entity
        $builder
            ->add('title', TextType::class, [
                'label' => 'Title',
                'attr' => [
                    'class' => 'form-control',  // Bootstrap class for styling
                    'placeholder' => 'Enter title',
                ],
                'label_attr' => ['class' => 'form-label'], // Adding Bootstrap class to the label
                'constraints' => [
                    new NotBlank([
                        'message' => 'Title is required.',
                    ]),
                ],
            ])
            ->add('message', TextareaType::class, [
                'label' => 'Message',
                'attr' => [
                    'class' => 'form-control',  // Bootstrap class for styling
                    'placeholder' => 'Enter message',
                    'rows' => 5,  // Optional: Set number of rows for textarea
                ],
                'label_attr' => ['class' => 'form-label'], // Adding Bootstrap class to the label
                'constraints' => [
                    new NotBlank([
                        'message' => 'Message content is required.',
                    ]),
                ],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Send Message',
                'attr' => ['class' => 'btn btn-success'], // Bootstrap class for styling the button
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
