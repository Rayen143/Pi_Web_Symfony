<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;


#ORM Entity (repository Class: EventRepository::class)]

class Event
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $eventId=null;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $ticketcount=null;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $hostId=null;


    #[ORM\Column (length: 150)]
    private ?string $locationId = null;


    #[ORM\Column (length: 150)]
    private ?string $title = null;

    #[ORM\Column (length: 150)]
    private ?string $type = null;

    #[ORM\Column (length: 150)]
    private ?string $description = null;
    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="startdate", type="date", nullable=true)
     */
    private $startdate;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="enddate", type="date", nullable=true)
     */
    private $enddate;


    #[ORM\Column (length: 150)]
    private ?string $affiche = null;

    #[ORM\Column (length: 150)]
    private ?string $ticketprice = null;
    
    public function getEventId(): ?int
    {
        return $this->eventId;
    }

    public function getTicketcount(): ?int
    {
        return $this->ticketcount;
    }

    public function setTicketcount(?int $ticketcount): static
    {
        $this->ticketcount = $ticketcount;

        return $this;
    }

    public function getHostId(): ?int
    {
        return $this->hostId;
    }

    public function setHostId(?int $hostId): static
    {
        $this->hostId = $hostId;

        return $this;
    }

    public function getLocationId(): ?string
    {
        return $this->locationId;
    }

    public function setLocationId(?string $locationId): static
    {
        $this->locationId = $locationId;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getStartdate(): ?\DateTimeInterface
    {
        return $this->startdate;
    }

    public function setStartdate(?\DateTimeInterface $startdate): static
    {
        $this->startdate = $startdate;

        return $this;
    }

    public function getEnddate(): ?\DateTimeInterface
    {
        return $this->enddate;
    }

    public function setEnddate(?\DateTimeInterface $enddate): static
    {
        $this->enddate = $enddate;

        return $this;
    }

    public function getAffiche(): ?string
    {
        return $this->affiche;
    }

    public function setAffiche(?string $affiche): static
    {
        $this->affiche = $affiche;

        return $this;
    }

    public function getTicketprice(): ?string
    {
        return $this->ticketprice;
    }

    public function setTicketprice(?string $ticketprice): static
    {
        $this->ticketprice = $ticketprice;

        return $this;
    }


}
