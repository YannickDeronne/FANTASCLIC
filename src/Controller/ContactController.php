<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Repository\ContactRepository;
use App\Service\SendMailService;
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
     * @Route("/contact", name="contact")
     *
     */
    public function contact(Request $request, SendMailService $mail)
    {
        $form = $this->createForm(ContactType::class);

        $contact = $form->handleRequest($request);

        // message flash 'votre message a été bien envoyé'
        if ($form->isSubmitted() && $form->isValid()) {
            $context = [
                'mail' => $contact->get('email')->getData(),
                'subject' => $contact->get('subject')->getData(),
                'message' => $contact->get('message')->getData(),
            ];
            $mail->send(
                $contact->get('email')->getData(),
                'shojiayane@gmail.com',
                'Message depuis le formulaire',
                'email',
                $context
            );

            //$this->addFlash('message', 'Votre message a été bien envoyé');
            return $this->redirectToRoute('accueil');
        }

        return $this->render('emails/contact.html.twig', ['form' => $form->createView()]);
    }

}
