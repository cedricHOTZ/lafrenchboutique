<?php

namespace App\Controller\Admin;

use App\Entity\Order;
use Doctrine\DBAL\Types\BooleanType;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class OrderCrudController extends AbstractCrudController
{
    private $entityManager;
    private $adminUrlGenerator;
    private $crudUrlGenerator;
    public const ACTION_DUPLICATE = 'Préparation en cours';
    public const ACTION_DELIVERY = 'En cours de livraison';

    public function __construct(EntityManagerInterface $entityManager,AdminUrlGenerator $adminUrlGenerator)
    {
        $this->entityManager = $entityManager;
        $this->adminUrlGenerator = $adminUrlGenerator;
       
    }

    public static function getEntityFqcn(): string
    {
        return Order::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        $updatePreparation = Action::new(self::ACTION_DUPLICATE)->linkToCrudAction('updatePreparation')->setIcon('fas fa-box-open');
        $updateDelivery = Action::new(self::ACTION_DELIVERY)->linkToCrudAction('updateDelivery')->setIcon('fas fa-truck');
        return $actions
            ->add(Crud::PAGE_EDIT, $updatePreparation )
            ->add(Crud::PAGE_EDIT,$updateDelivery );
         
    }
    

    public function updatePreparation(AdminContext $context,AdminUrlGenerator $adminUrlGenerator,EntityManagerInterface $entityManager){
    
    $order = $context->getEntity()->getInstance();
    $updatePreparation = clone $order;
    $order->setState(2);
    $this->entityManager->flush();
    $this->addFlash('notice',"<span style='color:green;'><strong>La commande " .$order->getReference(). " est bien en cours de préparation</strong></span>");
    parent::persistEntity($entityManager,$updatePreparation);
    $url = $adminUrlGenerator
    ->setController(OrderCrudController::class)
    ->setAction(Action::DETAIL);
    
    //envoyer un email pour avertir le client
    // $mail = new Mail();
    // $mail->send($order->getUser())


    return $this->redirect($url);
    }

    public function updateDelivery(AdminContext $context,AdminUrlGenerator $adminUrlGenerator,EntityManagerInterface $entityManager){
    
        $order = $context->getEntity()->getInstance();
        $updateDelivery = clone $order;
        $order->setState(3);
        $this->entityManager->flush();
        $this->addFlash('notice',"<span style='color:green;'><strong>La commande " .$order->getReference(). " est bien en cours de livraison</strong></span>");
        parent::persistEntity($entityManager,$updateDelivery);
        $url = $adminUrlGenerator
        ->setController(OrderCrudController::class)
        ->setAction(Action::DETAIL);
        return $this->redirect($url);
        }

    public function configureCrud(Crud $crud): Crud
    {
      return $crud->setDefaultSort(['id' => 'DESC']);  
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            DateField::new('createdAt','Passée le'),
            TextField::new('user.FullName','Utilisateur'),
            TextEditorField::new('delivery','Adresse de livraison')->onlyOnDetail(),
            MoneyField::new('total','total produit')->setCurrency('EUR'),
            TextField::new('carrierName','transporteur'),
            MoneyField::new('carrierPrice','frais de port')->setCurrency('EUR'),
            ChoiceField::new('state','status')->setChoices([
            "Non payée" => 0,
            "Payée" =>1,
            "Préparation en cours" => 2,
            "Livraison en cours" => 3
            ]),
            ArrayField::new('orderDetails','Produits achetés')->hideOnIndex()
        ];
    }
    
}
