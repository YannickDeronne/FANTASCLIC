<?php

namespace App\Entity;

use App\Repository\FilmRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=FilmRepository::class)
 */
class Film
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $titre;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $annee;

    /**
     * @ORM\ManyToMany(targetEntity=Genre::class, inversedBy="films")
     */
    private $genre;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\Range(min=0, max=999, notInRangeMessage = "La durée doit être comprise entre 0 et 999 minutes.")
     */
    private $duree;

    /**
     * @ORM\ManyToOne(targetEntity=Realisateur::class, inversedBy="films")
     * @ORM\JoinColumn(nullable=false)
     */
    private $realisateur;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $casting;


    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $synopsis;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $noteAdmin;

    /**
     * @ORM\OneToMany(targetEntity=Commentaire::class, mappedBy="film")
     */
    private $noteUtilisateur;

    /**
     * @ORM\OneToMany(targetEntity=Commentaire::class, mappedBy="avis")
     */
    private $avisUtilisateur;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $dispo;

    /**
     * @ORM\ManyToMany(targetEntity=Film::class, inversedBy="suggestionFilm")
     */
    private $suggestion;

    /**
     * @ORM\ManyToMany(targetEntity=Film::class, mappedBy="suggestion")
     */
    private $suggestionFilm;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $bandeAnnonce;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $ost;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $affiche;

    /**
     * @ORM\ManyToOne(targetEntity=SJ::class, inversedBy="films")
     */
    private $sj;


    public function __construct()
    {
        $this->genre = new ArrayCollection();
        $this->noteUtilisateur = new ArrayCollection();
        $this->avisUtilisateur = new ArrayCollection();
        $this->suggestion = new ArrayCollection();
        $this->suggestionFilm = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getAnnee(): ?int
    {
        return $this->annee;
    }

    public function setAnnee(?int $annee): self
    {
        $this->annee = $annee;

        return $this;
    }

    /**
     * @return Collection|Genre[]
     */
    public function getGenre(): Collection
    {
        return $this->genre;
    }

    public function addGenre(Genre $genre): self
    {
        if (!$this->genre->contains($genre)) {
            $this->genre[] = $genre;
        }

        return $this;
    }

    public function removeGenre(Genre $genre): self
    {
        $this->genre->removeElement($genre);

        return $this;
    }

    public function getDuree(): ?int
    {
        return $this->duree;
    }

    public function setDuree(?int $duree): self
    {
        $this->duree = $duree;

        return $this;
    }

    public function getRealisateur(): ?Realisateur
    {
        return $this->realisateur;
    }

    public function setRealisateur(?Realisateur $realisateur): self
    {
        $this->realisateur = $realisateur;

        return $this;
    }

    public function getCasting(): ?string
    {
        return $this->casting;
    }

    public function setCasting(?string $casting): self
    {
        $this->casting = $casting;

        return $this;
    }

    public function getSynopsis(): ?string
    {
        return $this->synopsis;
    }

    public function setSynopsis(?string $synopsis): self
    {
        $this->synopsis = $synopsis;

        return $this;
    }

    public function getNoteAdmin(): ?int
    {
        return $this->noteAdmin;
    }

    public function setNoteAdmin(?int $noteAdmin): self
    {
        $this->noteAdmin = $noteAdmin;

        return $this;
    }

    /**
     * @return Collection|Commentaire[]
     */
    public function getNoteUtilisateur(): Collection
    {
        return $this->noteUtilisateur;
    }

    public function addNoteUtilisateur(Commentaire $noteUtilisateur): self
    {
        if (!$this->noteUtilisateur->contains($noteUtilisateur)) {
            $this->noteUtilisateur[] = $noteUtilisateur;
            $noteUtilisateur->setFilm($this);
        }

        return $this;
    }

    public function removeNoteUtilisateur(Commentaire $noteUtilisateur): self
    {
        if ($this->noteUtilisateur->removeElement($noteUtilisateur)) {
            // set the owning side to null (unless already changed)
            if ($noteUtilisateur->getFilm() === $this) {
                $noteUtilisateur->setFilm(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Commentaire[]
     */
    public function getAvisUtilisateur(): Collection
    {
        return $this->avisUtilisateur;
    }

    public function addAvisUtilisateur(Commentaire $avisUtilisateur): self
    {
        if (!$this->avisUtilisateur->contains($avisUtilisateur)) {
            $this->avisUtilisateur[] = $avisUtilisateur;
            $avisUtilisateur->setFilm($this);
        }

        return $this;
    }

    public function removeAvisUtilisateur(Commentaire $avisUtilisateur): self
    {
        if ($this->avisUtilisateur->removeElement($avisUtilisateur)) {
            // set the owning side to null (unless already changed)
            if ($avisUtilisateur->getFilm() === $this) {
                $avisUtilisateur->setFilm(null);
            }
        }

        return $this;
    }

    public function getDispo(): ?string
    {
        return $this->dispo;
    }

    public function setDispo(?string $dispo): self
    {
        $this->dispo = $dispo;

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getSuggestion(): Collection
    {
        return $this->suggestion;
    }

    public function addSuggestion(self $suggestion): self
    {
        if (!$this->suggestion->contains($suggestion)) {
            $this->suggestion[] = $suggestion;
        }

        return $this;
    }

    public function removeSuggestion(self $suggestion): self
    {
        $this->suggestion->removeElement($suggestion);

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getSuggestionFilm(): Collection
    {
        return $this->suggestionFilm;
    }

    public function addSuggestionFilm(self $suggestionFilm): self
    {
        if (!$this->suggestionFilm->contains($suggestionFilm)) {
            $this->suggestionFilm[] = $suggestionFilm;
            $suggestionFilm->addSuggestion($this);
        }

        return $this;
    }

    public function removeSuggestionFilm(self $suggestionFilm): self
    {
        if ($this->suggestionFilm->removeElement($suggestionFilm)) {
            $suggestionFilm->removeSuggestion($this);
        }

        return $this;
    }

    public function getBandeAnnonce(): ?string
    {
        return $this->bandeAnnonce;
    }

    public function setBandeAnnonce(?string $bandeAnnonce): self
    {
        $this->bandeAnnonce = $bandeAnnonce;

        return $this;
    }

    public function getOst(): ?string
    {
        return $this->ost;
    }

    public function setOst(?string $ost): self
    {
        $this->ost = $ost;

        return $this;
    }

    public function getAffiche(): ?string
    {
        return $this->affiche;
    }

    public function setAffiche(?string $affiche): self
    {
        $this->affiche = $affiche;

        return $this;
    }

    public function getSj(): ?SJ
    {
        return $this->sj;
    }

    public function setSj(?SJ $sj): self
    {
        $this->sj = $sj;

        return $this;
    }

    
}
