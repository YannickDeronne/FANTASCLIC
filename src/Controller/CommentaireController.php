<?php

namespace App\Controller;

use App\Repository\CommentaireRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CommentaireController extends AbstractController
{

    /**
     * @var EntityMangaerInterface
     */
    private $manager;

    /**
     * @var CommentaireRepository
     */
    private $commentaireRepository;

    public function __construct(EntityManagerInterface $manager, CommentaireRepository $commentaireRepository)
    {
        $this->manager = $manager;
        $this->commentaireRepository = $commentaireRepository;
    }
}
