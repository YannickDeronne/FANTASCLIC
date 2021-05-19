<?php

namespace App\Controller;

use App\Repository\FilmRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{

    /**
     * @var EntityManagerInterface
     */
    private $manager;

    /**
     * @var FilmRepository
     */
    private $filmRepository;

    public function __construct(EntityManagerInterface $manager, FilmRepository $filmRepository, )
    {

        $this->manager = $manager;
        $this->filmRepository = $filmRepository;
    }

    /**
     * @Route("/", name="accueil")
     */
    public function home(Request $request)
    {

        $listfilm = $this->filmRepository->findAll();

        return $this->render("accueil.html.twig", ['listfilm' => $listfilm]);
    }

    /**
     * @Route("/top", name="top")
     */
    public function Top() {
        return $this->render("top.html.twig");
    }

    /**
     * @Route("/a_propos", name="a_propos")
     */
    public function aPropos()
    {
        return $this->render("apropos.html.twig");
    }

}
