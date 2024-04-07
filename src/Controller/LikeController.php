<?php

namespace App\Controller;

use App\Entity\Like;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Request as BrowserKitRequest;

class LikeController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    /**
     * @Route("/products/{id}/like", name="app_product_like",  methods={"GET"})
     */
    public function like(Product $product, Request $request): Response
    {
        // récupère l'utilisateur courant
        $user = $this->getUser();
        //s'il n'y en a pas, il crée un nouvel objet "Like",
        if (!$this->entityManager->getRepository(Like::class)->findOneBy(['user' => $user, 'product' => $product])) {
            $like = new Like();
            $like->setUser($user);
            $like->setProduct($product);
            $product->setLikeCount($product->getLikeCount() + 1);
            $this->entityManager->persist($like);
            $this->entityManager->flush();

            $this->addFlash('success', 'Like ajouté');
        }

        //Ce code vérifie la référence précédente (d'où vient l'utilisateur) 
        $referrer = $request->headers->get('referer');
        if (strpos($referrer, '/products') !== false) {
            return $this->redirectToRoute('app_products');
        } else {
            return $this->redirectToRoute('app_product', ['slug' => $product->getSlug()]);
        }
        // return $this->redirectToRoute('app_products', [ 'id' => $product->getId() ]);

    }

    /**
     * @Route("/products/{id}/unlike", name="product_unlike", methods={"GET"})
     * @param Product $product
     * @return Response
     */
    public function unlike(Product $product, $id, Request $request): Response
    {
        // récupère l'utilisateur courant
        $user = $this->getUser();
        $like = $this->entityManager->getRepository(Like::class)->findOneBy(['user' => $user, 'product' => $product]);

        // s'il existe un objet "Like", le supprime et décrémente le compteur de "j'aime" et empèche le like négatif
        if ($like) {
            if ($product->getLikeCount() > 0) {
                $product->setLikeCount($product->getLikeCount() - 1);
            }

            // $entityManager = $this->entityManager->getManager();
            $this->entityManager->remove($like);
            $this->entityManager->flush();
            $this->addFlash('success', 'Le like est supprimé');
        }

        $referrer = $request->headers->get('referer');
        if (strpos($referrer, '/products') !== false) {
            return $this->redirectToRoute('app_products');
        } else {
            return $this->redirectToRoute('app_product', ['slug' => $product->getSlug()]);
        }
        // return $this->redirectToRoute('app_products', [ 'id' => $id ]);
    }
}
