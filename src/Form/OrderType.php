<?php

namespace App\Form;

use App\Entity\Address;
use App\Entity\Transporteur;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $user = $options['user'];
        $builder
            ->add('addresses', EntityType::class,[
               'label' => false,
                'required' => true,
                'class' => Address::class,
                'choices' => $user->getAddresses(),
                'multiple' => false,
                'expanded' => true,
                'attr' => [
                    'class' => 'form-check-input appearance-none rounded-full mt-3'
                    ]
                ])
                ->add('transporteur', EntityType::class,[
                    'label' => false,
                    'label' =>'Choisir mon transporteur',
                     'required' => true,
                     'class' => Transporteur::class,
                     'multiple' => false,
                     'expanded' => true,
                     'attr' => [
                         'class' => 'form-check-input appearance-none rounded-full mt-3'
                         ]
                     ])
                     ->add('submit',SubmitType::class,[
                        'label' => 'Valider ma commande',
                        'attr' => [
                            'class' => 'inline px-6 py-2.5 bg-blue-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out'
                            ]
                        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
            'user' => array()
        ]);
    }
}
