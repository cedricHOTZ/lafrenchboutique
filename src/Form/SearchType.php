<?php

namespace App\Form;

use App\Class\Search;
use App\Entity\Category;
use Doctrine\DBAL\Types\FloatType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class SearchType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('string', TextType::class, [
                'required' => false,
                'label' => false,
                'attr' => [
                    'placeholder' => 'Recherche...',
                    'class' => 'form-control block w-full px-3 py-1.5 text-base font-normal text-gray-700 placeholder-gray-400 bg-white bg-clip-padding border border-solid border-gray-300 rounded-md transition ease-in-out focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500'
                ]
            ])
            ->add('categories', EntityType::class, [
                'label' => false,
                'required' => false,
                'class' => Category::class,
                'multiple' => true,
                'expanded' => true,
                'attr' => [
                    'class' => 'text-white',
                ]
            ])
            ->add('min', IntegerType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => 'Prix min',
                    'class' => 'form-control w-full px-3 py-1.5 text-base font-normal text-gray-700 placeholder-gray-400 bg-white bg-clip-padding border border-solid border-gray-300 rounded-md transition ease-in-out focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500'
                ]
            ])
            ->add('max', IntegerType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => 'Prix max',
                    'class' => 'form-control w-full px-3 py-1.5 text-base font-normal text-gray-700 placeholder-gray-400 bg-white bg-clip-padding border border-solid border-gray-300 rounded-md transition ease-in-out focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500'
                ]
            ])
            ->add('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'inline-block px-6 py-2.5 bg-blue-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out'
                ],
                'label' => 'Filtrer',
            ]);
    }



    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Search::class,
            'method' => 'GET',
            'csrf_protection' => false,
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }
}
