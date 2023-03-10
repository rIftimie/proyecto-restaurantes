<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[UniqueEntity(fields: ['username'], message: 'There is already an account with this username')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $username = null;

    #[ORM\Column(length: 180, unique: false)]
    private ?string $firstName = null;

    #[ORM\Column(length: 180, unique: false)]
    private ?string $lastName = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\ManyToOne(inversedBy: 'users')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Restaurant $restaurant = null;

    #[ORM\Column]
    private ?bool $hidden = false;

    #[ORM\OneToMany(mappedBy: 'madeBy', targetEntity: Orders::class)]
    private Collection $ordersMade;

    #[ORM\OneToMany(mappedBy: 'deliveredBy', targetEntity: Orders::class)]
    private Collection $ordersDelivered;

    public function __construct()
    {
        $this->ordersMade = new ArrayCollection();
        $this->ordersDelivered = new ArrayCollection();
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

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->username;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getRestaurant(): ?Restaurant
    {
        return $this->restaurant;
    }

    public function setRestaurant(?Restaurant $restaurant): self
    {
        $this->restaurant = $restaurant;

        return $this;
    }

    public function isHidden(): ?bool
    {
        return $this->hidden;
    }

    public function setHidden(bool $hidden): self
    {
        $this->hidden = $hidden;

        return $this;
    }
    public function __toString()
    {
        return  $this->username;
    }

    /**
     * @return Collection<int, Orders>
     */
    public function getOrdersMade(): Collection
    {
        return $this->ordersMade;
    }

    public function addOrdersMade(Orders $ordersMade): self
    {
        if (!$this->ordersMade->contains($ordersMade)) {
            $this->ordersMade->add($ordersMade);
            $ordersMade->setMadeBy($this);
        }

        return $this;
    }

    public function removeOrdersMade(Orders $ordersMade): self
    {
        if ($this->ordersMade->removeElement($ordersMade)) {
            // set the owning side to null (unless already changed)
            if ($ordersMade->getMadeBy() === $this) {
                $ordersMade->setMadeBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Orders>
     */
    public function getOrdersDelivered(): Collection
    {
        return $this->ordersDelivered;
    }

    public function addOrdersDelivered(Orders $ordersDelivered): self
    {
        if (!$this->ordersDelivered->contains($ordersDelivered)) {
            $this->ordersDelivered->add($ordersDelivered);
            $ordersDelivered->setDeliveredBy($this);
        }

        return $this;
    }

    public function removeOrdersDelivered(Orders $ordersDelivered): self
    {
        if ($this->ordersDelivered->removeElement($ordersDelivered)) {
            // set the owning side to null (unless already changed)
            if ($ordersDelivered->getDeliveredBy() === $this) {
                $ordersDelivered->setDeliveredBy(null);
            }
        }

        return $this;
    }
}
