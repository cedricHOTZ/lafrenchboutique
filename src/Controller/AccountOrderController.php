<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\OrderDetails;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AccountOrderController extends AbstractController
{

    private $entityManager;


    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/compte/mes-commandes', name: 'app_account_order')]
    public function index(): Response
    {
        $orders = $this->entityManager->getRepository(Order::class)->findSuccessOrders($this->getUser());
        return $this->render('account/order.html.twig', [
            'orders' => $orders

        ]);
    }

    #[Route('/compte/mes-commandes/{reference}', name: 'app_account_order_show')]
    public function show($reference): Response
    {
        $order = $this->entityManager->getRepository(Order::class)->findOneByReference($reference);

        // si lorder n'existe pas ou l'utilisateur ne correspond pas à la commande
        if(!$order || $order->getUser() != $this->getUser()){
        return $this->redirectToRoute('home');
        }
        return $this->render('account/order_show.html.twig', [
            'order' => $order

        ]);
    }
}
