<?php

namespace App\Entity;

use App\Repository\CommentaireRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommentaireRepository::class)
 */
class Commentaire
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Utilisateur::class, inversedBy="commentaires")
     * @ORM\JoinColumn(nullable=false)
     */
    private $pseudoUtilisateur;

    /**
     * @ORM\Column(type="integer")
     */
    private $noteUtilisateur;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $avisUtilisateur;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity=Film::class, inversedBy="noteUtilisateur")
     */
    private $film;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPseudoUtilisateur(): ?Utilisateur
    {
        return $this->pseudoUtilisateur;
    }

    public function setPseudoUtilisateur(?Utilisateur $pseudoUtilisateur): self
    {
        $this->pseudoUtilisateur = $pseudoUtilisateur;

        return $this;
    }

    public function getNoteUtilisateur(): ?int
    {
        return $this->noteUtilisateur;
    }

    public function setNoteUtilisateur(int $noteUtilisateur): self
    {
        $this->noteUtilisateur = $noteUtilisateur;

        return $this;
    }

    public function getAvisUtilisateur(): ?string
    {
        return $this->avisUtilisateur;
    }

    public function setAvisUtilisateur(?string $avisUtilisateur): self
    {
        $this->avisUtilisateur = $avisUtilisateur;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface$date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getFilm(): ?Film
    {
        return $this->film;
    }

    public function setFilm(?Film $film): self
    {
        $this->film = $film;

        return $this;
    }

}
