<?php

namespace App\Controller\Admin;

use App\Entity\Section1Home;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Vich\UploaderBundle\Form\Type\VichImageType;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class Section1HomeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Section1Home::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            // TextField::new('imageFile')->setFormType(VichImageType::class)->onlyWhenCreating(), 
            ImageField::new('illustration')->setUploadDir('public/uploads/')->setBasePath('/uploads/')->setLabel('Image')->setRequired(false),
            TextField::new('title'),
            TextField::new('subTitle'),
            TextEditorField::new('content'),
        ];
    }
    
}
