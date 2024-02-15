<?php

// src/Entity/PrimeSalarie.php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class PrimeSalarie
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Prime")
     * @ORM\JoinColumn(nullable=false)
     */
    private $prime;

    /**
     * @ORM\ManyToOne(targetEntity="Salarie")
     * @ORM\JoinColumn(nullable=false)
     */
    private $salarie;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $montant;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrime(): ?Prime
    {
        return $this->prime;
    }

    public function setPrime(?Prime $prime): self
    {
        $this->prime = $prime;

        return $this;
    }

    public function getSalarie(): ?Salarie
    {
        return $this->salarie;
    }

    public function setSalarie(?Salarie $salarie): self
    {
        $this->salarie = $salarie;

        return $this;
    }

    public function getMontant(): ?float
    {
        return $this->montant;
    }

    public function setMontant(float $montant): self
    {
        $this->montant = $montant;

        return $this;
    }
}
