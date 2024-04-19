<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;


 #ORM Entity (repository Class: PanierRepository::class)]


class Panier
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $idpanier=null;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $quantite=null;

    #[ORM\ManyToOne (inversedBy: 'paniers')]
    private ?Prod $idproduit = null;


    #[ORM\ManyToOne (inversedBy: 'paniers')]
    private ?User $iduser = null;


    public function getIdpanier(): ?int
    {
        return $this->idpanier;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): static
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getIdproduit(): ?Prod
    {
        return $this->idproduit;
    }

    public function setIdproduit(?Prod $idproduit): static
    {
        $this->idproduit = $idproduit;

        return $this;
    }

    public function getIduser(): ?User
    {
        return $this->iduser;
    }

    public function setIduser(?User $iduser): static
    {
        $this->iduser = $iduser;

        return $this;
    }


}
