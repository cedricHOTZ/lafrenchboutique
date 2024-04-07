<?php

namespace App\Controller;

use App\Class\Cart;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CartController extends AbstractController
{
    private $entityManager;
  


    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        
    }
    #[Route('/mon-panier', name: 'cart')]
    public function index(Cart $cart): Response
    {
       
        return $this->render('cart/index.html.twig', [
            'controller_name' => 'CartController',
            'cart' =>$cart->getfull()

        ]);
    }


    #[Route('/cart/add/{id}', name: 'add_to_cart')]
    public function add(Cart $cart, $id): Response
    {
        $cart->add($id);
       
        return $this->redirectToRoute('cart');
         
    }

    #[Route('/cart/delete/{id}', name: 'delete_to_cart')]
    public function delete(Cart $cart, $id): Response
    {
        $cart->delete($id);
       
        return $this->redirectToRoute('cart');
         
    }
  
    #[Route('/cart/remove', name: 'remove-cart')]
    public function remove(Cart $cart): Response
    {
        $cart->remove();
       
        return $this->redirectToRoute('products');
         
    }

    #[Route('/cart/diminier/{id}', name: 'diminuer-cart')]
    public function diminuer(Cart $cart, $id): Response
    {
        $cart->diminuer($id);
       
        return $this->redirectToRoute('cart');
         
    }
}
