<?php

namespace App\Controller;

use App\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OrderCancelController extends AbstractController
{
    private $entityManger;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManger = $entityManager;
    }
    #[Route("/commande/erreur/{stripeSessionId}", name: 'app_order_erreur')]
    public function index($stripeSessionId)
    {
        $order = $this->entityManger->getRepository(Order::class)->findOneByStripeSessionId($stripeSessionId);

        if(!$order || $order->getUser() != $this->getUser()){
        return $this->redirectToRoute('app_home');
        }

       
        return $this->render('order_cancel/erreur.html.twig', [
           'order' => $order
        ]);
    }
}
