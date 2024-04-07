<?php

namespace App\Controller\Admin;

use App\Entity\ReassuranceLeft;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ReassuranceLeftCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ReassuranceLeft::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            TextField::new('title'),
            TextEditorField::new('content'),
            ImageField::new('illustration')->setUploadDir('public/uploads/')->setBasePath('/uploads/')->setLabel('Image')->setRequired(false),
        ];
    }
    
}
