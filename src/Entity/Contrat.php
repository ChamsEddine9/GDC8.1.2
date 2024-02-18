<?php

// src/Entity/Contrat.php

namespace App\Entity;

use App\Enum\TypeContrat;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ContratRepository::class)]
class Contrat
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 3)]
    private ?TypeContrat $type;

    // ...

    public function getType(): ?TypeContrat
    {
        return $this->type;
    }

    public function setType(TypeContrat $type): static
    {
        $this->type = $type;

        return $this;
    }

    // ...
}
