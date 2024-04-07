<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/contact', name: 'app_contact')]
    public function index(Request $request): Response
    {


        $notification = null;

        $contact = new contact;


        $form = $this->createForm(ContactFormType::class, $contact, []);

        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            $contact->setDate(new \DateTime());
            $this->entityManager->persist($contact);
            $this->entityManager->flush();

            $notification =  $this->addFlash('success', 'Votre formulaire a bien été envoyé');

            return $this->redirectToRoute('app_contact');
        }


        return $this->render('contact/index.html.twig', [
            'form' => $form->createView(),
            'notification' => $notification,

        ]);
    }
}
