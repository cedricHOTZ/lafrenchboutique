<?php


// Service qui génère le fil d'Ariane
namespace App\Service;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class BreadcrumbService
{
    private $requestStack;
    private $urlGenerator;

    public function __construct(RequestStack $requestStack, UrlGeneratorInterface $urlGenerator)
    {
        $this->requestStack = $requestStack;
        $this->urlGenerator = $urlGenerator;
    }

    public function getBreadcrumb()
    {
        $request = $this->requestStack->getCurrentRequest();
        $route = $request->attributes->get('_route');
        $breadcrumb = [];

        switch ($route) {
            case 'home':
                $breadcrumb[] = ['name' => 'Accueil', 'url' => $this->urlGenerator->generate('home')];
                break;
            case 'category':
                $category = $request->attributes->get('category');
                $breadcrumb[] = ['name' => 'Accueil', 'url' => $this->urlGenerator->generate('home')];
                $breadcrumb[] = ['name' => $category->getName(), 'url' => $this->urlGenerator->generate('category', ['id' => $category->getId()])];
                break;
            case 'product':
                $product = $request->attributes->get('product');
                $breadcrumb[] = ['name' => 'product', 'url' => $this->urlGenerator->generate('product')];
                $breadcrumb[] = ['name' => $product->getCategory()->getName(), 'url' => $this->urlGenerator->generate('category', ['id' => $product->getCategory()->getId()])];
                $breadcrumb[] = ['name' => $product->getName(), 'url' => $this->urlGenerator->generate('product', ['id' => $product->getId()])];
                break;
        }

        return $breadcrumb;
    }
}
