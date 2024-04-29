<?php

namespace App\Form;

use App\Entity\Reservation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType; // Import EntityType
use App\Entity\Evenement;
use App\Entity\Event;
use App\Entity\User;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Validator\Constraints\Range;
class ReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nombreplace')
            ->add('nom_user', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Regex([
                        'pattern' => '/^[a-zA-Z]+$/',
                        'message' => 'The user name should contain only letters.',
                    ]),
                ],
            ])


            ->add('prenom_user', TextType::class, [ // Add this line
                'constraints' => [ // Add this line
                    new NotBlank(), // Add this line
                    new Regex([ // Add this line
                        'pattern' => '/^[a-zA-Z]+$/', // Add this line
                        'message' => 'The user surname should contain only letters.', // Add this line
                    ]), // Add this line
                ], // Add this line
            ]) // Add this line
            ->add('age', IntegerType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Range([
                        'min' => 16,
                        'minMessage' => 'The user must be at least {{ limit }} years old.',
                    ]),
                ],
            ])
            
          // Replace the id_event field with EntityType
          ->add('id_event', EntityType::class, [
            'class' => Event::class,
            'choice_label' => 'nom_event', // Adjust to the property of Evenement you want to display
            // Add more options as needed
        ])
        ->add('id_user', EntityType::class, [
            'class' => User::class,
            'choice_label' => 'nom', // Adjust to the property of User you want to display
            // Add more options as needed
        ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
        ]);
    }
}
