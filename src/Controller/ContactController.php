<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Repository\ContactRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private $manager;

    /**
     * @var ContactRepository
     */
    private $contactRepository;

    public function __construct(EntityManagerInterface $manager, ContactRepository $contactRepository)
    {
        $this->manager = $manager;
        $this->contactRepository = $contactRepository;
    }

    /**
     * @Route("contact", name="contact")
     *
     */
    public function createContact(Request $request)
    {
        $contact = new Contact();

        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        // message flash 'votre message a été bien envoyé'
        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->persist($contact);
            $this->manager->flush();
            return $this->redirectToRoute('accueil');
        }

        return $this->render('contact.html.twig', ['form' => $form->createView()]);
    }

}
