<?php

namespace App\Entity;

use App\Repository\RealisateurRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RealisateurRepository::class)
 */
class Realisateur
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $anneeNaissance;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $anneeDeces;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(?string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getAnneeNaissance(): ?int
    {
        return $this->anneeNaissance;
    }

    public function setAnneeNaissance(?int $anneeNaissance): self
    {
        $this->anneeNaissance = $anneeNaissance;

        return $this;
    }

    public function getAnneeDeces(): ?int
    {
        return $this->anneeDeces;
    }

    public function setAnneeDeces(?int $anneeDeces): self
    {
        $this->anneeDeces = $anneeDeces;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }
}
