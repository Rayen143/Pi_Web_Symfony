<?php

namespace App\Entity;

use App\Repository\ReductionRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: ReductionRepository::class)]

class Reduction
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $idreduction=null;

    #[ORM\Column (length: 150)]
    #[Assert\NotBlank(message:"code produit est obligatoire")]
    private ?string $codeproduit = null;


    #[ORM\Column]
    #[Assert\NotBlank(message:"remise est obligatoire")]
    #[Assert\Length(min: 1, minMessage:"le min 1 numéro ")]
    #[Assert\Length(max: 3, maxMessage:"le max 3 numéro ")]

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


    public function calculerNouveauPrix(): ?float
    {
        if ($this->prixunitaire !== null && $this->remise !== null) {
            return $this->prixunitaire * (1 - ($this->remise / 100));
        }
        return null;
    }   


}
