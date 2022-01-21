<?php

namespace App\Entity;

use App\Repository\RoomRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RoomRepository::class)]
class Room
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $name;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $onlyForPremiumMembers;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $image;

    #[ORM\Column(type: 'boolean', options: ['default' => false])]
    private ?bool $onlyPremiumMembers;

    #[ORM\ManyToOne(targetEntity: Bookings::class, inversedBy: 'rooms')]
    private ?Bookings $booking;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getOnlyForPremiumMembers(): ?string
    {
        return $this->onlyForPremiumMembers;
    }

    public function setOnlyForPremiumMembers(string $onlyForPremiumMembers): self
    {
        $this->onlyForPremiumMembers = $onlyForPremiumMembers;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getOnlyPremiumMembers(): ?bool
    {
        return $this->onlyPremiumMembers;
    }

    public function setOnlyPremiumMembers(bool $onlyPremiumMembers): self
    {
        $this->onlyPremiumMembers = $onlyPremiumMembers;

        return $this;
    }

    public function getBookings(): ?Bookings
    {
        return $this->bookings;
    }

    public function setBookings(?Bookings $bookings): self
    {
        $this->bookings = $bookings;

        return $this;
    }

    public function getBooking(): ?Bookings
    {
        return $this->booking;
    }

    public function setBooking(?Bookings $booking): self
    {
        $this->booking = $booking;

        return $this;
    }

    function canBook(User $user) {
        return ($this->getOnlyPremiumMembers() && $user->getPremiumMember()) || !$this->getOnlyPremiumMembers();
    }
}
