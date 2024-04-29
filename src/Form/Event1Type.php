<?php

namespace App\Form;

use App\Entity\Event;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Event1Type extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options): void
  {
    $builder
      ->add('ticketcount')
      ->add('hostId')
      ->add('locationId')
      ->add('title')
      ->add('type')
      ->add('description')
      // Add start and end date fields with html5 and single_text widget
      ->add('startDate', DateType::class, [
        'label' => 'Start Date',
        'html5' => true, // Use HTML5 date input
        'widget' => 'single_text', // Use single text input
      ])
      ->add('endDate', DateType::class, [
        'label' => 'End Date',
        'html5' => true, // Use HTML5 date input
        'widget' => 'single_text', // Use single text input
      ])
      ->add('affiche')
      ->add('ticketprice');
  }

  public function configureOptions(OptionsResolver $resolver): void
  {
    $resolver->setDefaults([
      'data_class' => Event::class,
    ]);
  }
}