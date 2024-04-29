<?php

namespace App\Entity;

use App\Repository\PanierRepository;
use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity(repositoryClass: PanierRepository::class)]


class Panier
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $idpanier = null;




    #[ORM\ManyToOne(inversedBy: 'paniers')]
    #[ORM\JoinColumn(name: 'idproduit', referencedColumnName: 'id_produit')]
    private ?Prod $idproduit = null;

    #[ORM\ManyToOne(inversedBy: 'paniers')]
    #[ORM\JoinColumn(name: 'iduser', referencedColumnName: 'id')]
    private ?User $iduser = null;
    
    #[ORM\Column]
    private ?int $quantite=null;

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


    public function __toString()
{
    return $this->idpanier;
}


}
