<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#ORM Entity (repository Class: ReductionRepository::class)]

class Reduction
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $idreduction=null;

    #[ORM\Column (length: 150)]
    private ?string $codeproduit = null;


    #[ORM\Column]
    private ?float $remise = null;


    #[ORM\Column]
    private ?float $prixunitaire = null;


    #[ORM\Column]
    private ?float $nouveauprix = null;
    public function getIdreduction(): ?int
    {
        return $this->idreduction;
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

    public function getRemise(): ?float
    {
        return $this->remise;
    }

    public function setRemise(float $remise): static
    {
        $this->remise = $remise;

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

    public function getNouveauprix(): ?float
    {
        return $this->nouveauprix;
    }

    public function setNouveauprix(float $nouveauprix): static
    {
        $this->nouveauprix = $nouveauprix;

        return $this;
    }


}
