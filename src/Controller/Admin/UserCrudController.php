<?php

namespace App\Controller\Admin;

use App\Entity\Role;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            EmailField::new('email'),
            // AssociationField::new('userrole')
            //     ->setFormTypeOptions([
            //         'class' => Role::class,
            //         'choice_label' => 'name',
            //         'multiple' => true,
            //     ])
            //     ->setLabel('Roles'),

              ChoiceField::new('roles')
              ->allowMultipleChoices()

                  ->renderAsBadges([
                      'ROLE_ADMIN' => 'success',
                      'ROLE_USER' => 'info',


                  ])

                  ->setChoices([
                      'Administrateur' => 'ROLE_ADMIN',
                      'Auteur' => 'ROLE_USER',

                  ])
                  ->setHelp('Veuillez choisir un role')
                  ->setRequired(true)
                  ->setLabel('Rôle'),


            TextField::new('password')
                ->setFormType(PasswordType::class)
                ->onlyOnForms()->onlyOnIndex(),
        ];
    }
}
