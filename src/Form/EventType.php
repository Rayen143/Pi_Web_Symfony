<?php

namespace App\Form;

use App\Entity\Event;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Event Title',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a title for the event.',
                    ]),
                ],
            ])
            ->add('description', TextType::class, [
                'label' => 'Event Description',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a description for the event.',
                    ]),
                ],
            ])
            ->add('startdate', DateType::class, [
                'label' => 'Start Date',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter the start date for the event.',
                    ]),
                ],
            ])
            ->add('enddate', DateType::class, [
                'label' => 'End Date',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter the end date for the event.',
                    ]),
                ],
            ])
            ->add('location', TextType::class, [
                'label' => 'Location',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter the location of the event.',
                    ]),
                ],
            ])
            ->add('affiche', FileType::class, [  // Optional image upload
                'label' => 'Event Affiche (Image)',
                'mapped' => false, // This field is not mapped to an entity property
                'required' => false,
            ])
            ->add('ticketprice', MoneyType::class, [
                'label' => 'Ticket Price (Optional)',
                'currency' => 'USD',
                'required' => false,
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Save Event',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
