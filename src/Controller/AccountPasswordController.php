<?php

namespace App\Controller;

use App\Form\ChangePasswordType;
use App\Form\ChangePasswordFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request as HttpFoundationRequest;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactoryInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AccountPasswordController extends AbstractController
{
   private $entityManager;

    public function __construct(EntityManagerInterface $entityManager )
    {
        $this->entityManager = $entityManager;
    }



    #[Route('/account/password', name: 'app_account_password')]
    public function index(Request $request,UserPasswordHasherInterface $encoder): Response
    {
        $notification = null;

        //Utilisateur connecté
       $user = $this->getUser();
       
       // appel du form
       $form = $this->createForm(ChangePasswordType::class, $user);

    // Préparation du form
       $form->handleRequest($request);

       if($form->isSubmitted()&& $form->isValid()){
         $old_password = $form->get('old_password')->getData();

         if($encoder->isPasswordValid($user,$old_password)){
            $new_password = $form->get('new_Password')->getdata();
            $password = $encoder->hashPassword($user, $new_password);
            $user->setPassword($password);
            $this->entityManager->persist($user);
            $this->entityManager->flush();
           $notification =  $this->addFlash('success','Votre mot de passe a bien été modifié');
            return $this->redirectToRoute('app_account');
         }else{
            $notification =  $this->addFlash('error','Votre mot de passe actuel n\'est pas le bon');
            
         }
       }
        return $this->render('account/password.html.twig', [
            'controller_name' => 'AccountPasswordController',
            'form' => $form->createView(),
            'notification' => $notification,
         
        ]);
    }
}
