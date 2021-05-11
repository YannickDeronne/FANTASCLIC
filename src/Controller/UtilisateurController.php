<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\UtilisateurType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UtilisateurController extends AbstractController {

    /**
     * @var EntityManagerInterface
     */
    private $manager;

    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    public function __construct(EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder) {
        $this->manager = $manager;
        $this->encoder = $encoder;
    }


        /**
     * @Route("/enregistrer", name="enregistrer_utilisateur")
     */
    public function registerUtilisateur(Request $request) {
        $utilisateur = new Utilisateur();
        $form = $this->createForm(UtilisateurType::class, $utilisateur);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $utilisateur->setRoles(["ROLE_USER"]);
            $encodedPassword = $this->encoder->encodePassword($utilisateur, $utilisateur->getPassword());
            $utilisateur->setPassword($encodedPassword);

            $this->manager->persist($utilisateur);
            $this->manager->flush();
            return $this->redirectToRoute('app_login');
        }
        
        return $this->render('utilisateurs/creer_utilisateur.html.twig', ['form' => $form->createView()]);   
    }


    /**
     * @Route("/admin/enregistrer", name="enregistrer_admin")
     */
    public function registerAdmin(Request $request) {
        $utilisateur = new Utilisateur();
        $form = $this->createForm(UtilisateurType::class, $utilisateur);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $utilisateur->setRoles(["ROLE_ADMIN"]);
            $encodedPassword = $this->encoder->encodePassword($utilisateur, $utilisateur->getPassword());
            $utilisateur->setPassword($encodedPassword);

            $this->manager->persist($utilisateur);
            $this->manager->flush();
            return $this->redirectToRoute('app_login');
        }
        
        return $this->render('utilisateurs/creer_utilisateur.html.twig', ['form' => $form->createView()]);  
    }

}