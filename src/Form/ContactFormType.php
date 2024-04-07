<?php

namespace App\Form;

use App\Entity\Contact;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ContactFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName', TextType::class, [
                'label' => 'Votre prénom',
                'required' => true,
                'attr' => [
                    'class' => 'form-control block
                    w-full
                    px-3
                    py-1.5
                    text-base
                    font-normal
                    text-white
                    bg-white bg-clip-padding
                    border border-solid border-gray-300
                    rounded
                    transition
                    ease-in-out
                    m-0
                    focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" id="exampleInput7'
                ],
                'label_attr' => [
                    'class' => 'text-white', // Définissez la classe pour le label en blanc
                ],
            ])
            ->add('lastName', TextType::class, [
                'label' => 'Votre nom',
                'required' => true,
                'attr' => [
                    'class' => 'form-control block
                    w-full
                    px-3
                    py-1.5
                    text-base
                    font-normal
                    text-white
                    bg-white bg-clip-padding
                    border border-solid border-gray-300
                    rounded
                    transition
                    ease-in-out
                    m-0
                    focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" id="exampleInput7'
                ],
                'label_attr' => [
                    'class' => 'text-white', // Définissez la classe pour le label en blanc
                ],
            ])
            ->add('email', EmailType::class, [
                'label' => 'Votre email',
                'required' => true,
                'attr' => [
                    'class' => 'form-control block
                    w-full
                    px-3
                    py-1.5
                    text-base
                    font-normal
                    text-white
                    bg-white bg-clip-padding
                    border border-solid border-gray-300
                    rounded
                    transition
                    ease-in-out
                    m-0
                    focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" id="exampleInput7'
                ],
                'label_attr' => [
                    'class' => 'text-white', // Définissez la classe pour le label en blanc
                ],
            ])
            ->add('phone', TelType::class, [
                'label' => 'Votre numéro de téléphone',
                'required' => false,
                'attr' => [
                    'class' => 'form-control block
                    w-full
                    px-3
                    py-1.5
                    text-base
                    font-normal
                    text-white
                    bg-white bg-clip-padding
                    border border-solid border-gray-300
                    rounded
                    transition
                    ease-in-out
                    m-0
                    focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" id="exampleInput7'
                ],
                'label_attr' => [
                    'class' => 'text-white', // Définissez la classe pour le label en blanc
                ],
            ])
            ->add('content', TextareaType::class, [
                'label' => 'Votre texte',
                'required' => true,
                'attr' => [
                    'class' => 'form-control
                    block
                    w-full
                    px-3
                    py-1.5
                    text-base
                    font-normal
                    text-white
                    bg-white bg-clip-padding
                    border border-solid border-gray-300
                    rounded
                    transition
                    ease-in-out
                    m-0
                    focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none
                  " id="exampleFormControlTextarea13" rows="5" col="5"'
                ],
                'label_attr' => [
                    'class' => 'text-white', // Définissez la classe pour le label en blanc
                ],
            ])
            ->add('object', TextType::class, [
                'label' => 'Objet',
                'required' => true,
                'attr' => [
                    'class' => 'form-control block
                    w-full
                    px-3
                    py-1.5
                    text-base
                    font-normal
                    text-white
                    bg-white bg-clip-padding
                    border border-solid border-gray-300
                    rounded
                    transition
                    ease-in-out
                    m-0
                    focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" id="exampleInput7'
                ],
                'label_attr' => [
                    'class' => 'text-white', // Définissez la classe pour le label en blanc
                ],
            ])
            ->add('confidentialite', CheckboxType::class, [
                'label' => 'En cochant cette case, vous acceptez d’être recontacté par email, conformément à notre Politique de Confidentialité.',
                'required' => true,
                'attr' => [
                    'class' => 'form-check-input appearance-none h-4 w-4 border border-gray-300 rounded-sm bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain mr-2 cursor-pointer'
                ],
                'label_attr' => [
                    'class' => 'text-white', // Définissez la classe pour le label en blanc
                ],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'ENVOYER',
                'attr' => [
                    'class' => ' w-full
                            px-6
                            py-2.5
                            bg-blue-600
                            text-white
                            font-medium
                            text-xs
                            leading-tight
                            uppercase
                            rounded
                            shadow-md
                            hover:bg-blue-700 hover:shadow-lg
                            focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0
                            active:bg-blue-800 active:shadow-lg
                            transition
                            duration-150
                            ease-in-out'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
