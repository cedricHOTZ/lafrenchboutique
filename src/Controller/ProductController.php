<?php

namespace App\Controller;

use App\Entity\Like;
use App\Entity\User;
use App\Class\Search;
use App\Entity\Product;
use App\Entity\Category;
use App\Form\SearchType;
use PhpParser\Node\Expr\New_;
use Doctrine\ORM\EntityManager;
use App\Service\BreadcrumbService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class ProductController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }



    #[Route('/products', name: 'app_products')]

    public function index(Request $request): Response
    {
        $user = $this->getUser();

        // Filtres
        $search = new Search();
        $form = $this->createForm(SearchType::class, $search);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $products = $this->entityManager->getRepository(Product::class)->findWithSearch($search);
        } else {
            $products = $this->entityManager->getRepository(Product::class)->findAll();
        }

        // Ajout de la propriété liked à chaque produit
        foreach ($products as $product) {
            $like = $this->entityManager->getRepository(Like::class)->findOneBy(['user' => $user, 'product' => $product]);
            $product->setLiked($like !== null);
        }

        return $this->render('product/index.html.twig', [
            'products' => $products,
            'form' => $form->createView(),

        ]);
    }

    #[Route('/product/{slug}', name: 'app_product')]
    public function show($slug, EntityManagerInterface $entityManagerInterface, BreadcrumbService $breadcrumbService): Response
    {

        $breadcrumb = $breadcrumbService->getBreadcrumb();

        $user = $this->getUser();
        $isBest = $entityManagerInterface->getRepository(Product::class)->findByIsBest(1);
        $product = $this->entityManager->getRepository(Product::class)->findOneBySlug($slug);

        if (!$product) {
            return $this->redirectToRoute('app_products');
        }
        $like = $entityManagerInterface->getRepository(Like::class)->findOneBy(['user' => $user, 'product' => $product]);
        $product->setLiked($like !== null);
        // $product->setLiked($likes !== null);

        return $this->render('product/product.html.twig', [
            'product' => $product,
            'isBest' => $isBest,
            'user' => $user,
            'breadcrumb' => $breadcrumb,


        ]);
    }
}
