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
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\String\Slugger\SluggerInterface;

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
    public function createFilm (Request $request, SluggerInterface $slugger) {

        $film = new Film();

        $form = $this->createForm(FilmType::class, $film);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            if (str_contains($film->getBandeAnnonce(), 'watch?v=')) {
                $explode = explode ("=", $film->getBandeAnnonce());
                $youtubeIdBA = $explode[1];
                $youtubeLinkBA = "https://www.youtube.com/embed/" . $youtubeIdBA;
                $film->setBandeAnnonce($youtubeLinkBA);
            }

            /**
             * @var UploadedFile $affiche
             */

            $affiche = $form->get('affiche')->getData();

            if ($affiche) {
                $originalFilename = pathinfo($affiche->getClientOriginalName(), PATHINFO_FILENAME);
                
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $affiche->guessExtension();

                try {
                    $affiche->move($this->getParameter('affiches_directory'), $newFilename);
                } 
                catch (FileException $e) {
                    throw new HttpException(404);
                }
                
                $film->setAffiche($newFilename);
            }
            dump ($film);
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
    public function updateFilm(Request $request, int $id, SluggerInterface $slugger) {
        $film = $this->filmRepository->find($id);

        if ($film == null) {
            throw new HttpException(404);
        }

        $form = $this->createForm(FilmType::class, $film);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if (str_contains($film->getBandeAnnonce(), 'watch?v=')) {
                $explode = explode ("=", $film->getBandeAnnonce());
                $youtubeIdBA = $explode[1];
                $youtubeLinkBA = "https://www.youtube.com/embed/" . $youtubeIdBA;
                $film->setBandeAnnonce($youtubeLinkBA);
            }


            /**
             * @var UploadedFile $affiche
             */

            $affiche = $form->get('affiche')->getData();

            if ($affiche) {
                $originalFilename = pathinfo($affiche->getClientOriginalName(), PATHINFO_FILENAME);
                
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $affiche->guessExtension();

                try {
                    $affiche->move($this->getParameter('affiches_directory'), $newFilename);
                } 
                catch (FileException $e) {
                    throw new HttpException(404);
                }
                
                $film->setAffiche($newFilename);
            }
            $this->manager->persist($film);
            $this->manager->flush();
            return $this->redirectToRoute('list_film');
            }

        return $this->render('films/update.html.twig', ['form' => $form->createView()]);
        
    }

    /**
     * @Route("film/delete/{id}", name="delete_film", requirements={"id"="\d+"})
     */
    // @IsGranted("ROLE_ADMIN") ligne 105
    public function deletefilm(Request $request, int $id) {
        $film = $this->filmRepository->find($id);

        $this->manager->remove($film);
        $this->manager->flush();

        return $this->redirectToRoute('list_film');
    } 
}