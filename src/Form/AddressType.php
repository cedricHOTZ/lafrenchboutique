<?php

namespace App\Form;

use App\Entity\Address;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name',TextType::class,[
                'label' => 'Quel nom souhaitez-vous donner à votre adresse ?',
                'attr' => [
                    'placeholder' => "Nommez votre adresse"
                    ]
                ])
            ->add('firstname',TextType::class,[
                'label' => 'Votre prénom',
                'attr' => [
                    'placeholder' => "entrez votre prénom"
                    ]
                ])
            ->add('lastname',TextType::class,[
                'label' => 'Votre nom',
                'attr' => [
                    'placeholder' => "entrez votre nom"
                    ]
                ])
            ->add('company',TextType::class,[
                'label' => 'Votre société',
                'attr' => [
                    'placeholder' => "(facultatif)Entrez le nom de votre société"
                    ]
                ])
            ->add('address',TextType::class,[
                'label' => 'Votre adresse',
                'attr' => [
                    'placeholder' => "7 rue des lilas"
                    ]
                ])
            ->add('postal',TextType::class,[
                'label' => 'Votre code postal',
                'attr' => [
                    'placeholder' => "Entrez votre code postal"
                    ]
                ])
            ->add('city',TextType::class,[
                'label' => 'Ville',
                'attr' => [
                    'placeholder' => "Votre ville"
                    ]
                ])
            ->add('country',CountryType::class,[
                'label' => 'Pays',
                'attr' => [
                    'placeholder' => "Votre pays",
                    'choice_label' => "France"
                    ]
                ])
            ->add('phone',TelType::class,[
                'label' => 'Votre téléphone',
                'attr' => [
                    'placeholder' => "Entrez votre numéro"
                    ]
                ])
            ->add('submit', SubmitType::class,[
                'label' => 'Ajouter une adresse',
                'attr' => [
                    'class' =>'inline-block px-6 py-2.5 bg-blue-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out',
                    ]
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Address::class,
        ]);
    }
}
