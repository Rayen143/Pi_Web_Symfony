<?php

namespace App\Form;

use App\Repository\CategorieRepository;
use App\Entity\Prod;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

use Symfony\Component\Validator\Constraints\File;
class ProductsFormType extends AbstractType
{
    private $categorieRepository;

    public function __construct(CategorieRepository $categorieRepository)
    {
        $this->categorieRepository = $categorieRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $categories = $this->categorieRepository->findAll(); // Fetch all categories from the repository

        // Map categories to a format suitable for choices in the form field
        $choices = [];
        foreach ($categories as $categorie) {
            $choices[$categorie->getLibcategorie()] = $categorie->getLibcategorie();
        }

        $builder
            ->add('codeproduit')
            ->add('des')
            ->add('idunite')
            ->add('cat', ChoiceType::class, [
                'choices' => $choices,
            ])
            ->add('image', FileType::class, [
                'label' => 'Product Image',
                'required' => false,
                'mapped' => false, // This option is important to prevent the field from being mapped to an entity property
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid image file (JPEG, PNG)',
                    ])
                ],
            ])
            ->add('qtemin')
            ->add('qtestock')
            ->add('prixunitaire');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Prod::class,
        ]);
    }
}
