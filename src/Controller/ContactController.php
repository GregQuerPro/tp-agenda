<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Repository\ContactRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    #[Route('/contact/{id}', name: 'contact')]
    public function index($id, ContactRepository $repository): Response
    {
        $contact = $repository->find($id);
        return $this->render('contact/index.html.twig', [
            'contact' => $contact
        ]);
    }

    #[Route('/contacts/add', name: 'contact-add')]
    public function add(Request $request, EntityManagerInterface $em): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $this->addFlash(
                'success',
                'Nouveau contact enregistré avec succès!'
            );

            $contact = $form->getData();
            $em->persist($contact);
            $em->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('contact/add.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('/contacts/{id}', name: 'contact-edit')]
    public function edit(Request $request, Contact $contact, EntityManagerInterface $em): Response
    {

        $form = $this->createForm(ContactType::class, $contact);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $this->addFlash(
                'success',
                'Contact modifié avec succès!'
            );

            $contact = $form->getData();
            $em->persist($contact);
            $em->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('contact/edit.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('/contact/delete/{id}', name: 'contact-delete')]
    public function delete($id, ContactRepository $repository): Response
    {
        $contact = $repository->find($id);
        $repository->remove($contact, true);
        return $this->redirectToRoute('home');
    }
}
