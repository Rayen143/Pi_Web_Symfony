<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\AvisRepository;

#[ORM\Entity(repositoryClass: AvisRepository::class)]

 
class Avis
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $idProduit=null;

    #[ORM\Column (length: 150)]
    private ?string $contenu = null;
    public function getIdProduit(): ?int
    {
        return $this->idProduit;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): static
    {
        $this->contenu = $contenu;

        return $this;
    }


}
