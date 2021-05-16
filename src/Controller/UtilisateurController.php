<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\UtilisateurType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

class UtilisateurController extends AbstractController
{

    /**
     * @var EntityManagerInterface
     */
    private $manager;

    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    public function __construct(EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder)
    {
        $this->manager = $manager;
        $this->encoder = $encoder;
    }

    /**
     * @Route("/register", name="register_utilisateur")
     */
    public function registerUtilisateur(Request $request, SluggerInterface $slugger)
    {
        $utilisateur = new Utilisateur();
        $form = $this->createForm(UtilisateurType::class, $utilisateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $utilisateur->setRoles(["ROLE_USER"]);
            $encodedPassword = $this->encoder->encodePassword($utilisateur, $utilisateur->getPassword());
            $utilisateur->setPassword($encodedPassword);

            // Upload file
            /**
             * @var UploadedFile $avatarImage
             */
            $avatarImage = $form->get('avatar')->getData();

            if ($avatarImage) {
                $originalFilename = pathinfo($avatarImage->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $avatarImage->guessExtension();

                try {
                    $avatarImage->move(
                        $this->getParameter('avatars_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    throw new HttpException(404);
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $utilisateur->setAvatar($newFilename);

                $this->manager->persist($utilisateur);
                $this->manager->flush();
                return $this->redirectToRoute('app_login');
            }

        }
        return $this->render('utilisateurs/create.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/utilisateurs", name="detail_utilisateur")
     */
    public function utilisateur()
    {
        return $this->render('utilisateurs/detail.html.twig');
    }

    /**
     * @Route("/admin/register", name="register_admin")
     */
    public function registerAdmin(Request $request)
    {
        $utilisateur = new Utilisateur();
        $form = $this->createForm(UtilisateurType::class, $utilisateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $utilisateur->setRoles(["ROLE_ADMIN"]);
            $encodedPassword = $this->encoder->encodePassword($utilisateur, $utilisateur->getPassword());
            $utilisateur->setPassword($encodedPassword);

            $this->manager->persist($utilisateur);
            $this->manager->flush();
            return $this->redirectToRoute('app_login');
        }

        return $this->render('utilisateurs/create_utilisateur.html.twig', ['form' => $form->createView()]);
    }

}
