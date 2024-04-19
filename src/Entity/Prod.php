<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;


  #ORM Entity (repository Class: ProdRepository::class)]

class Prod
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $idProduit=null;

    #[ORM\Column (length: 150)]
    private ?string $codeproduit = null;
 
    #[ORM\Column (length: 150)]
    private ?string $des = null;

    #[ORM\Column (length: 150)]
    private ?string $idunite = null;


    #[ORM\Column (length: 150)]
    private ?string $cat = null;


    #[ORM\Column (length: 150)]
    private ?string $image = null;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $qtemin=null;
  
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $qtestock=null;

    #[ORM\Column]
    private ?float $prixunitaire = null;
    public function getIdProduit(): ?int
    {
        return $this->idProduit;
    }

    public function getCodeproduit(): ?string
    {
        return $this->codeproduit;
    }

    public function setCodeproduit(string $codeproduit): static
    {
        $this->codeproduit = $codeproduit;

        return $this;
    }

    public function getDes(): ?string
    {
        return $this->des;
    }

    public function setDes(string $des): static
    {
        $this->des = $des;

        return $this;
    }

    public function getIdunite(): ?string
    {
        return $this->idunite;
    }

    public function setIdunite(?string $idunite): static
    {
        $this->idunite = $idunite;

        return $this;
    }

    public function getCat(): ?string
    {
        return $this->cat;
    }

    public function setCat(string $cat): static
    {
        $this->cat = $cat;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getQtemin(): ?int
    {
        return $this->qtemin;
    }

    public function setQtemin(int $qtemin): static
    {
        $this->qtemin = $qtemin;

        return $this;
    }

    public function getQtestock(): ?int
    {
        return $this->qtestock;
    }

    public function setQtestock(int $qtestock): static
    {
        $this->qtestock = $qtestock;

        return $this;
    }

    public function getPrixunitaire(): ?float
    {
        return $this->prixunitaire;
    }

    public function setPrixunitaire(float $prixunitaire): static
    {
        $this->prixunitaire = $prixunitaire;

        return $this;
    }


}
