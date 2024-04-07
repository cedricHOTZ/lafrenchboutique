<?php

namespace App\Controller;

use App\Class\Cart;
use App\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OrderValidateController extends AbstractController
{
    private $entityManger;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManger = $entityManager;
    }
    #[Route('/commande/merci/{stripeSessionId}', name: 'app_order_validate')]
    public function index(Cart $cart,$stripeSessionId)
    {
        $order = $this->entityManger->getRepository(Order::class)->findOneByStripeSessionId($stripeSessionId);

        if(!$order || $order->getUser() != $this->getUser()){
        return $this->redirectToRoute('home');
        }

        if (!$order->getState() == 0){
            //supprime la session du panier
        $cart->remove();
        $order->setState(1);
        $this->entityManger->flush();
        }
        return $this->render('order_validate/index.html.twig', [
           'order' => $order
        ]);
    }
}
