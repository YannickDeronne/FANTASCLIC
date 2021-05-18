<?php

namespace App\Controller;

use App\Entity\Film;
use App\Form\FilmType;
use App\Repository\FilmRepository;
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
     * @Route("/films/create", name="create_film")
     */

    // @IsGranted("ROLE_ADMIN") ligne 36
    public function createFilm (Request $request) {

        $film = new Film();

        $form = $this->createForm(FilmType::class, $film);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            if (str_contains('watch?v=', $film->getBandeAnnonce())) {
                $explode = explode ("=", $film->getBandeAnnonce());
                $youtubeIdBA = $explode[1];
                $youtubeLinkBA = "https://www.youtube.com/embed/" . $youtubeIdBA;
                $film->setBandeAnnonce($youtubeLinkBA);
            }

            // re faire un autre explode après le "&" (et une fonction "if")
            // $explode = explode ("=", $film->getOst());
            // $youtubeIdOst = $explode[1];
            // $youtubeLinkOst = "https://www.youtube.com/embed/" . $youtubeIdOst;
            // $film->setOst($youtubeLinkOst);

            $this->manager->persist($film);
            $this->manager->flush();
            return $this->redirectToRoute('list_film');
        }
        
        return $this->render("films/create.html.twig", ['form' => $form->createView()]);
    }


    /**
     * @Route("/films", name="list_film")
     */
    public function listFilm(Request $request) {

        $filmList = $this->filmRepository->findAll();

        return $this->render('films/list.html.twig', ['filmList' => $filmList]);
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


    /**
     * @Route("/films/update/{id}", name="update_film", requirements={"id"="\d+"})
     */
    public function updateFilm(Request $request, int $id) {
        $film = $this->filmRepository->find($id);

        if ($film == null) {
            throw new HttpException(404);
        }

        $form = $this->createForm(FilmType::class, $film);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if (str_contains('watch?v=', $film->getBandeAnnonce())) {
                $explode = explode ("=", $film->getBandeAnnonce());
                $youtubeIdBA = $explode[1];
                $youtubeLinkBA = "https://www.youtube.com/embed/" . $youtubeIdBA;
                $film->setBandeAnnonce($youtubeLinkBA);
            }

            // re faire un autre explode après le "&" (et une fonction "if")
            // $explode = explode ("=", $film->getOst());
            // $youtubeIdOst = $explode[1];
            // $youtubeLinkOst = "https://www.youtube.com/embed/" . $youtubeIdOst;
            // $film->setOst($youtubeLinkOst);

            $this->manager->persist($film);
            $this->manager->flush();
            return $this->redirectToRoute('list_film');
        }

        return $this->render('films/update.html.twig', ['form' => $form->createView()]);
    }


    /**
     *@Route("film/delete/{id}", name="delete_film", requirements={"id"="\d+"})
     */
    // @IsGranted("ROLE_ADMIN") ligne 105
    public function deletefilm(Request $request, int $id) {
        $film = $this->filmRepository->find($id);

        $this->manager->remove($film);
        $this->manager->flush();

        return $this->redirectToRoute('list_film');
    }
}