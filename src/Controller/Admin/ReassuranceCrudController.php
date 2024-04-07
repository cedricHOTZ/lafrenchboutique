<?php

namespace App\Controller\Admin;

use App\Entity\Reassurance;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ReassuranceCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Reassurance::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            TextField::new('title'),
            ImageField::new('illustration')->setUploadDir('public/uploads/')->setBasePath('/uploads/')->setLabel('Image')->setRequired(false),
            TextEditorField::new('content')->setRequired(false),
            TextField::new('title'),
        ];
    }
    
}
