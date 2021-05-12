<?php

namespace App\Controller;

use App\Entity\Film;
use App\Form\FilmType;
use App\Repository\FilmRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpKernel\Exception\HttpException;

class FilmController extends AbstractController {

    /**
     * @var EntityManagerInterface
     */
    private $manager;

    /**
     * @var FilmRepository
     */
    private $filmRepository;

    public function __construct(EntityManagerInterface $manager, FilmRepository $filmRepository) {
        
        $this->manager = $manager;
        $this->filmRepository = $filmRepository;
    }
    

    /**
     * @Route("/films/ajouter", name="ajouter_film")
     */

    // @IsGranted("ROLE_ADMIN") ligne 36
    public function ajouterFilm (Request $request) {

        $film = new Film();
        $form = $this->createForm(FilmType::class, $film);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $film->setCreatedAt(new DateTime());
            $this->manager->persist($film);
            $this->manager->flush();
        }
        
        return $this->render("films/ajouter.html.twig", ['form' => $form->createView()]);
    }


    /**
     * @Route("/films", name="liste_film")
     */
    public function listeFilm(Request $request) {

        $listeFilm = $this->filmRepository->findAll();

        return $this->render('films/liste.html.twig', ['listefilm' => $listeFilm]);
    }


    /**
     * @Route("/films/{id}", name="detail_film", requirements={"id"="\d+"})
     */
    public function detailFilm(Request $request, int $id) {
        $film = $this->filmRepository->find($id);

        if($film == null) {
            throw new HttpException(404);
        }
        
        return $this->render("films/detail.html.twig", ['film' => $film]);
    }

}