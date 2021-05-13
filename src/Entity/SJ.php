<?php

namespace App\Entity;

use App\Repository\SJRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SJRepository::class)
 */
class SJ
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
    private $sj;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSj(): ?string
    {
        return $this->sj;
    }

    public function setSj(string $sj): self
    {
        $this->sj = $sj;

        return $this;
    }
}
