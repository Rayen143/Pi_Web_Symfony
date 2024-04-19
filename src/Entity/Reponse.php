<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;


 #ORM Entity (repository Class: ReponseRepository::class)]

class Reponse
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $repId=null;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $recId=null;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $adminId=null;
 
    #[ORM\Column (length: 150)]
    private ?string $repDesc = null;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_rep", type="date", nullable=false)
     */
    private $dateRep;

    public function getRepId(): ?int
    {
        return $this->repId;
    }

    public function getRecId(): ?int
    {
        return $this->recId;
    }

    public function setRecId(int $recId): static
    {
        $this->recId = $recId;

        return $this;
    }

    public function getAdminId(): ?int
    {
        return $this->adminId;
    }

    public function setAdminId(int $adminId): static
    {
        $this->adminId = $adminId;

        return $this;
    }

    public function getRepDesc(): ?string
    {
        return $this->repDesc;
    }

    public function setRepDesc(string $repDesc): static
    {
        $this->repDesc = $repDesc;

        return $this;
    }

    public function getDateRep(): ?\DateTimeInterface
    {
        return $this->dateRep;
    }

    public function setDateRep(\DateTimeInterface $dateRep): static
    {
        $this->dateRep = $dateRep;

        return $this;
    }


}
