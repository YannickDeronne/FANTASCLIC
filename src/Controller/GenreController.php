<?php

namespace App\Controller;

use App\Entity\Genre;
use App\Form\GenreType;
use App\Repository\GenreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class GenreController extends AbstractController {

    /**
     * @var EntityManagerInterface
     */
    private $manager;

    /**
     * @var GenreRepository
     */
    private $genreRepository;

    public function __construct(EntityManagerInterface $manager, GenreRepository $genreRepository) {
        
        $this->manager = $manager;
        $this->genreRepository = $genreRepository;
    }


    /**
     * @Route("/genres/create", name="create_genre")
     */
    // @IsGranted("ROLE_ADMIN") 
    public function createGenre (Request $request) {

        $genre = new Genre();

        $form = $this->createForm(GenreType::class, $genre);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $this->manager->persist($genre);
            $this->manager->flush();
            return $this->redirectToRoute('list_genre');
        }
        
        return $this->render("genres/create.html.twig", ['form' => $form->createView()]);
    }


    /**
     * @Route("/genres", name="list_genre")
     */
    public function listGenre(Request $request) {

        $genreList = $this->genreRepository->findAll();

        return $this->render('genres/list.html.twig', ['genreList' => $genreList]);
    }


    /**
     *@Route("genre/delete/{id}", name="delete_genre", requirements={"id"="\d+"})
     */
    // @IsGranted("ROLE_ADMIN")
    public function deletegenre(Request $request, int $id) {
        $genre = $this->genreRepository->find($id);

        $this->manager->remove($genre);
        $this->manager->flush();

        return $this->redirectToRoute('list_genre');
    }
}