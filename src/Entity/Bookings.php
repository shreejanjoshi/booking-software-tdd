<?php

namespace App\Entity;

use App\Repository\BookingsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookingsRepository::class)]
class Bookings
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\OneToMany(mappedBy: 'booking', targetEntity: Room::class)]
    private ArrayCollection $room;

    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $startDate;

    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $endDate;

    #[ORM\OneToMany(mappedBy: 'booking', targetEntity: Room::class)]
    private ArrayCollection $rooms;

    #[ORM\ManyToOne(targetEntity: NewUser::class, inversedBy: 'booking')]
    private ?NewUser $newUser;

    public function __construct()
    {
        $this->room = new ArrayCollection();
        $this->rooms = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|Room[]
     */
    public function getRoom(): Collection
    {
        return $this->room;
    }

    public function addRoom(Room $room): self
    {
        if (!$this->room->contains($room)) {
            $this->room[] = $room;
            $room->setBookings($this);
        }

        return $this;
    }

    public function removeRoom(Room $room): self
    {
        if ($this->room->removeElement($room)) {
            // set the owning side to null (unless already changed)
            if ($room->getBookings() === $this) {
                $room->setBookings(null);
            }
        }

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(\DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }

    /**
     * @return Collection|Room[]
     */
    public function getRooms(): Collection
    {
        return $this->rooms;
    }

    public function getNewUser(): ?NewUser
    {
        return $this->newUser;
    }

    public function setNewUser(?NewUser $newUser): self
    {
        $this->newUser = $newUser;

        return $this;
    }
}
