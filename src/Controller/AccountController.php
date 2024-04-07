<?php

namespace App\Controller;

use App\Form\ChangePasswordType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountController extends AbstractController
{
    #[Route('/account', name: 'app_account')]
    public function index(): Response
    {
        //utilisateur connecté
         $user = $this->getUser();
        // $form = $this->createForm(ChangePasswordType::class,$user);
        return $this->render('account/index.html.twig', [
        //   'form' => $form->createView(),
           

        ]);
    }
}
