<?php

namespace App\Controller\Admin;

use App\Entity\SectionHome;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use Vich\UploaderBundle\Form\Type\VichImageType;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class SectionHomeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return SectionHome::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            // TextField::new('imageFile')->setFormType(VichImageType::class), 
            ImageField::new('illustration')->setUploadDir('public/uploads/')->setBasePath('/uploads/')->setLabel('Image')->setRequired(false),
            TextField::new('title'),
            TextField::new('subTitle'),
            TextEditorField::new('content'),
        ];
    }
    
}
