<?php

// src/Entity/Salarie.php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SalarieRepository::class)]
class Salarie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $matricule = null;

    #[ORM\Column(type: 'date', nullable: true)]
    private ?\DateTimeInterface $dateNaissance = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $adresse = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $ville = null;

    #[ORM\Column(type: 'date', nullable: true)]
    private ?\DateTimeInterface $dateEmbauche = null;

    #[ORM\Column(type: 'date', nullable: true)]
    private ?\DateTimeInterface $dateDebutContrat = null;

    #[ORM\Column(type: 'date', nullable: true)]
    private ?\DateTimeInterface $dateFinContrat = null;

    #[ORM\Column(type: 'date', nullable: true)]
    private ?\DateTimeInterface $debutPeriodeEssai = null;

    #[ORM\Column(type: 'date', nullable: true)]
    private ?\DateTimeInterface $finPeriodeEssai = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $delaiPreavis = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $numCNSS = null;

    #[ORM\Column(type: 'float', nullable: true)]
    private ?float $salaireBase = null;

    #[ORM\ManyToOne(targetEntity: Dossier::class)]
    private ?Dossier $dossier = null;

    #[ORM\OneToOne(targetEntity: Contrat::class, cascade: ['persist', 'remove'])]
    private ?Contrat $contrat = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getMatricule(): ?string
    {
        return $this->matricule;
    }

    public function setMatricule(?string $matricule): static
    {
        $this->matricule = $matricule;

        return $this;
    }

    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->dateNaissance;
    }

    public function setDateNaissance(?\DateTimeInterface $dateNaissance): static
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(?string $adresse): static
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(?string $ville): static
    {
        $this->ville = $ville;

        return $this;
    }

    public function getDateEmbauche(): ?\DateTimeInterface
    {
        return $this->dateEmbauche;
    }

    public function setDateEmbauche(?\DateTimeInterface $dateEmbauche): static
    {
        $this->dateEmbauche = $dateEmbauche;

        return $this;
    }

    public function getDateDebutContrat(): ?\DateTimeInterface
    {
        return $this->dateDebutContrat;
    }

    public function setDateDebutContrat(?\DateTimeInterface $dateDebutContrat): static
    {
        $this->dateDebutContrat = $dateDebutContrat;

        return $this;
    }

    public function getDateFinContrat(): ?\DateTimeInterface
    {
        return $this->dateFinContrat;
    }

    public function setDateFinContrat(?\DateTimeInterface $dateFinContrat): static
    {
        $this->dateFinContrat = $dateFinContrat;

        return $this;
    }

    public function getDebutPeriodeEssai(): ?\DateTimeInterface
    {
        return $this->debutPeriodeEssai;
    }

    public function setDebutPeriodeEssai(?\DateTimeInterface $debutPeriodeEssai): static
    {
        $this->debutPeriodeEssai = $debutPeriodeEssai;

        return $this;
    }

    public function getFinPeriodeEssai(): ?\DateTimeInterface
    {
        return $this->finPeriodeEssai;
    }

    public function setFinPeriodeEssai(?\DateTimeInterface $finPeriodeEssai): static
    {
        $this->finPeriodeEssai = $finPeriodeEssai;

        return $this;
    }

    public function getDelaiPreavis(): ?int
    {
        return $this->delaiPreavis;
    }

    public function setDelaiPreavis(?int $delaiPreavis): static
    {
        $this->delaiPreavis = $delaiPreavis;

        return $this;
    }

    public function getNumCNSS(): ?string
    {
        return $this->numCNSS;
    }

    public function setNumCNSS(?string $numCNSS): static
    {
        $this->numCNSS = $numCNSS;

        return $this;
    }

    public function getSalaireBase(): ?float
    {
        return $this->salaireBase;
    }

    public function setSalaireBase(?float $salaireBase): static
    {
        $this->salaireBase = $salaireBase;

        return $this;
    }

    public function getDossier(): ?Dossier
    {
        return $this->dossier;
    }

    public function setDossier(?Dossier $dossier): static
    {
        $this->dossier = $dossier;

        return $this;
    }

    public function getContrat(): ?Contrat
    {
        return $this->contrat;
    }

    public function setContrat(?Contrat $contrat): static
    {
        $this->contrat = $contrat;

        return $this;
    }

}


