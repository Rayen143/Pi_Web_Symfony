<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;


 #ORM Entity (repository Class: CategorieRepository::class)]

class Categorie
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $idcategorie=null;

    #[ORM\Column (length: 150)]
    private ?string $libcategorie = null;
    public function getIdcategorie(): ?int
    {
        return $this->idcategorie;
    }

    public function getLibcategorie(): ?string
    {
        return $this->libcategorie;
    }

    public function setLibcategorie(string $libcategorie): static
    {
        $this->libcategorie = $libcategorie;

        return $this;
    }


}
