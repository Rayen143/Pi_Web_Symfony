<?php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PaymentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('cardNumber', TextType::class, [
                'label' => 'Numéro de carte'
            ])
            // Ajout du champ pour le CVV2
            ->add('cvv2', TextType::class, [
                'label' => 'CVV2'
            ])            
            ->add('expirationDate', TextType::class, [
                'label' => 'Date d\'expiration'
            ])

            // Ajoutez d'autres champs de formulaire pour le code de sécurité, le nom du titulaire, etc.
            // Assurez-vous de valider ces champs correctement pour des raisons de sécurité.
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Pas besoin de lier à une entité
        ]);
    }
}
