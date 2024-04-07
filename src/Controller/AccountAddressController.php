<?php

namespace App\Controller;

use App\Class\Cart;
use App\Entity\Address;
use App\Form\AddressType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class AccountAddressController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    #[Route('/account/address', name: 'app_account_address')]
    public function index(): Response
    {
        return $this->render('account/address.html.twig', [
            
        ]);
    }

    #[Route('/account/ajouter-une-address', name: 'app_account_address_add')]
    public function add(Request $request , Cart $cart): Response
    {
      $address = new Address();
        $form = $this->createForm(AddressType::class, $address);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            // Pour avoir l'utilisateur en question
        $address->setUser($this->getUser());
        $this->entityManager->persist($address);
        $this->entityManager->flush();
        // Si j'ai des produits dans mon panier
        if ($cart->get()){
            return $this->redirectToRoute('app_order');
        }else{
       return $this->redirectToRoute('app_account_address');
        }
    }
        return $this->render('account/address_add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/account/modifier-une-address/{id}', name: 'app_account_address_edit')]
    public function edit(Request $request, $id): Response
    {
     $address = $this->entityManager->getRepository(Address::class)->findOneById($id);
           // Est ce que l'adresse existe et vérifier si l'adresse appartient bien à l'utilisateur
     if (!$address || $address->getUser() != $this->getUser()){
        
        return $this->redirectToRoute('app_account_address');
        }

        $form = $this->createForm(AddressType::class, $address);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            // Pour avoir l'utilisateur en question
       
        $this->entityManager->flush();
       return $this->redirectToRoute('app_account_address');
        }

        return $this->render('account/address_add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/account/supprimer-une-address/{id}', name: 'app_account_address_delete')]
    public function delete($id): Response
    {
     $address = $this->entityManager->getRepository(Address::class)->findOneById($id);
           // Est ce que l'adresse existe et vérifier si l'adresse appartient bien à l'utilisateur
     if ($address && $address->getUser() == $this->getUser()){
        
       $this->entityManager->remove($address);
       $this->entityManager->flush();
        }

       
        return $this->redirectToRoute('app_account_address');
        
    }
}
