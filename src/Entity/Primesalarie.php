<?php

// src/Entity/PrimeSalarie.php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PrimeSalarieRepository::class)]
class PrimeSalarie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Salarie::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Salarie $salarie = null;

    #[ORM\ManyToOne(targetEntity: Prime::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Prime $prime = null;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
    private ?float $montant = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSalarie(): ?Salarie
    {
        return $this->salarie;
    }

    public function setSalarie(?Salarie $salarie): static
    {
        $this->salarie = $salarie;

        return $this;
    }

    public function getPrime(): ?Prime
    {
        return $this->prime;
    }

    public function setPrime(?Prime $prime): static
    {
        $this->prime = $prime;

        return $this;
    }

    public function getMontant(): ?float
    {
        return $this->montant;
    }

    public function setMontant(float $montant): static
    {
        $this->montant = $montant;

        return $this;
    }

    // Ajoutez d'autres getters et setters selon vos besoins
}
