<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;


#ORM Entity (repository Class: ReservationRepository::class)]

class Reservation
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $idres=null;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $idev=null;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $iduser=null;
 
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $nombredeplace=null;

    #[ORM\Column (length: 150)]
    private ?string $nom = null;


    #[ORM\Column (length: 150)]
    private ?string $prenom = null;
    public function getIdres(): ?int
    {
        return $this->idres;
    }

    public function getIdev(): ?int
    {
        return $this->idev;
    }

    public function setIdev(int $idev): static
    {
        $this->idev = $idev;

        return $this;
    }

    public function getIduser(): ?int
    {
        return $this->iduser;
    }

    public function setIduser(int $iduser): static
    {
        $this->iduser = $iduser;

        return $this;
    }

    public function getNombredeplace(): ?int
    {
        return $this->nombredeplace;
    }

    public function setNombredeplace(int $nombredeplace): static
    {
        $this->nombredeplace = $nombredeplace;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(?string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }


}
