<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactFormType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactoController extends AbstractController
{
    #[Route('/contact', name: 'contact')]
    public function contact(ManagerRegistry $doctrine, Request $request): Response
    {
        $contact = new Contact();
        $form = $this -> createForm(ContactFormType::class,$contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $contact = $form->getData();
            $entityManager = $doctrine->getManager();
            $entityManager->persist($contact);
            $entityManager->flush();
            return $this->redirectToRoute('thankyou',[]);
        }

        return $this->render('contact.html.twig',
        ['form'=>$form->createView()]);
    }
}
