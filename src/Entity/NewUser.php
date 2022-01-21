<?php

namespace App\Entity;

use App\Repository\NewUserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NewUserRepository::class)]
class NewUser
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $username;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $password;

    #[ORM\Column(type: 'integer', options: ['default' => 100])]
    private ?int $credit;

    #[ORM\Column(type: 'boolean', options: ['default' => false])]
    private ?bool $premiumMember;

    #[ORM\OneToMany(mappedBy: 'newUser', targetEntity: Bookings::class)]
    private ArrayCollection $booking;

    public function __construct()
    {
        $this->booking = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getCredit(): ?int
    {
        return $this->credit;
    }

    public function setCredit(int $credit): self
    {
        $this->credit = $credit;

        return $this;
    }

    public function getPremiumMember(): ?bool
    {
        return $this->premiumMember;
    }

    public function setPremiumMember(bool $premiumMember): self
    {
        $this->premiumMember = $premiumMember;

        return $this;
    }

    /**
     * @return Collection|Bookings[]
     */
    public function getBooking(): Collection
    {
        return $this->booking;
    }

    public function addBooking(Bookings $booking): self
    {
        if (!$this->booking->contains($booking)) {
            $this->booking[] = $booking;
            $booking->setNewUser($this);
        }

        return $this;
    }

    public function removeBooking(Bookings $booking): self
    {
        if ($this->booking->removeElement($booking)) {
            // set the owning side to null (unless already changed)
            if ($booking->getNewUser() === $this) {
                $booking->setNewUser(null);
            }
        }

        return $this;
    }
    function canAfford(User $user, int $hour): bool
    {
        return ($user->getCredit() > $hour * 2);
    }
}
