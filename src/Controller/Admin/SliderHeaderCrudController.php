<?php

namespace App\Controller\Admin;

use App\Entity\SliderHeader;
use Vich\UploaderBundle\Form\Type\VichImageType;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class SliderHeaderCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return SliderHeader::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            TextField::new('title'),
            TextareaField::new('content'),
            TextField::new('btnTitle','Titre du bouton'),
            TextField::new('btnUrl','url du bouton'),
            // TextField::new('imageFile')->setFormType(VichImageType::class)->onlyWhenCreating(), 
             ImageField::new('illustration')->setUploadDir('public/uploads/')->setBasePath('/uploads/')->setLabel('Image')->setRequired(false),
        ];
    }
    
}
