<?php

namespace App\Controller;

use App\Entity\Realisateur;
use App\Form\RealisateurType;
use App\Repository\RealisateurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Routing\Annotation\Route;

class RealisateurController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private $manager;

    /**
     * @var RealisateurRepository
     */
    private $realisateurRepository;

    public function __construct(EntityManagerInterface $manager, RealisateurRepository $realisateurRepository)
    {
        $this->manager = $manager;
        $this->realisateurRepository = $realisateurRepository;
    }

    // Role admin @IsGranted("ROLE_ADMIN") à ajouter ci-dessous
    /**
     * @Route("realisateurs/create", name="create_realisateur")
     *
     */
    public function createRealisateur(Request $request)
    {
        $realisateur = new Realisateur();

        $form = $this->createForm(RealisateurType::class, $realisateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->persist($realisateur);
            $this->manager->flush();
            return $this->redirectToRoute('list_realisateur');
        }

        return $this->render('realisateurs/create.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/realisateurs", name="list_realisateur")
     */
    public function listRealisateur(Request $request)
    {
        $realisateurList = $this->realisateurRepository->findAll();
        return $this->render('realisateurs/list.html.twig', ['realisateurList' => $realisateurList]);
    }

    /**
     * @Route("/realisateurs/{id}", name="detail_realisateur")
     */
    public function detailRealisateur(Request $request, int $id)
    {
        $realisateur = $this->realisateurRepository->find($id);
        if (!$realisateur) {
            throw new HttpException(404);
        }

        return $this->render('realisateurs/detail.html.twig', ['realisateur' => $realisateur]);
    }
}
