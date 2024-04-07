<?php

namespace App\Controller;

use App\Class\Cart;
use App\Entity\Order;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class StripeController extends AbstractController
{
    #[Route('/commande/create-session/{reference}', name: 'stripe_create_session')]
    public function index(EntityManagerInterface $entityManagerInterface, Cart $cart, $reference)
    {
        $product_for_stripe = [];

        $YOUR_DOMAIN = 'http://127.0.0.1:8000/';

        $order = $entityManagerInterface->getRepository(Order::class)->findOneByReference($reference);

        if (!$order) {
            $this->redirect('app_order');
        }



        foreach ($order->getOrderDetails()->getValues() as $product) {
            $product_object = $entityManagerInterface->getRepository(Product::class)->findOneByName($product->getProduct());
            $product_for_stripe[] = [
                'price_data' => [
                    'currency' => 'eur',
                    'unit_amount' => $product->getPrice(),
                    'product_data' => [
                        'name' => $product->getProduct(),
                        'images' => [$YOUR_DOMAIN . "uploads/" . $product_object->getIllustration()],
                    ],

                ],
                'quantity' => $product->getQuantity(),
            ];
        }

        $product_for_stripe[] = [
            'price_data' => [
                'currency' => 'eur',
                'unit_amount' => $order->getCarrierPrice(),
                'product_data' => [
                    'name' => $order->getCarrierName(),
                //    'images' =>[$YOUR_DOMAIN."uploads/".$product->getIllustration()
                 'images' => [$YOUR_DOMAIN],
                
                ],

            ],
            'quantity' => 1,
        ];

        Stripe::setApiKey('sk_test_51LuY3eFOeryIA3NGE0wlGhqhJb7fuU2Q9t0vyVWzJcJgz2vq6IGbNQvYJMajiPrEQIWSCmxhzOLKwpzJitD7c3v800VLL9yVT9');

        header('Content-Type: application/json');



        $checkout_session = Session::create([
            'customer_email' => $this->getUser()->getEmail(),
            'payment_method_types' => ['card'],
            'line_items' =>  [
                [$product_for_stripe]
            ],
            'mode' => 'payment',
            'success_url' => $YOUR_DOMAIN . 'commande/merci/{CHECKOUT_SESSION_ID}',
            'cancel_url' => $YOUR_DOMAIN . '/commande/erreur/{CHECKOUT_SESSION_ID}',
        ]);
        
        $order->setStripeSessionId($checkout_session->id);
        $entityManagerInterface->flush();

        return $this->redirect($checkout_session->url);
    }
}
