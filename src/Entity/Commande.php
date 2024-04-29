<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;



#[ORM\Entity(repositoryClass: CommandeRepository::class)]

class Commande
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $idcommande=null;


    #[ORM\Column]
    private ?float $prix = null;

 
 
    #[ORM\Column]
    private ?int $tel=null;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datecommande", type="date", nullable=false)
     */
    private $datecommande;


 

    #[ORM\Column]
    private ?int $codepostal=null;

    #[ORM\Column (length: 150)]
    private ?string $rue = null;
 
    #[ORM\Column (length: 150)]
    private ?string $ville = null;

    #[ORM\ManyToOne(inversedBy: 'commandes')]
    #[ORM\JoinColumn(name: 'idpanier', referencedColumnName: 'idpanier')]
    private ?Panier $idpanier = null;
 
    #[ORM\ManyToOne(inversedBy: 'commandes')]
    #[ORM\JoinColumn(name: 'iduser', referencedColumnName: 'id')]
    private ?User $iduser = null;

    public function getIdcommande(): ?int
    {
        return $this->idcommande;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): static
    {
        $this->prix = $prix;

        return $this;
    }

    public function getTel(): ?int
    {
        return $this->tel;
    }

    public function setTel(int $tel): static
    {
        $this->tel = $tel;

        return $this;
    }

    public function getDatecommande(): ?\DateTimeInterface
    {
        return $this->datecommande;
    }

    public function setDatecommande(\DateTimeInterface $datecommande): static
    {
        $this->datecommande = $datecommande;

        return $this;
    }

    public function getCodepostal(): ?int
    {
        return $this->codepostal;
    }

    public function setCodepostal(int $codepostal): static
    {
        $this->codepostal = $codepostal;

        return $this;
    }

    public function getRue(): ?string
    {
        return $this->rue;
    }

    public function setRue(string $rue): static
    {
        $this->rue = $rue;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): static
    {
        $this->ville = $ville;

        return $this;
    }

    public function getIdpanier(): ?Panier
    {
        return $this->idpanier;
    }

    public function setIdpanier(?Panier $idpanier): static
    {
        $this->idpanier = $idpanier;

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
    if ($this->idpanier) {
        return $this->idpanier->getIdpanier();
    }
    return '';
}

public function __toString2()
{
    if ($this->iduser) {
        return $this->iduser->getId();
    }
    return '';
}


}
