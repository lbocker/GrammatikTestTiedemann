<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::STRING, length: 180)]
    private string $email;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column (type: Types::STRING, length: 255)]
    private string $password;

    #[ORM\Column(type: Types::INTEGER, options: ['default' => 0])]
    private int $points = 0;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image;

    #[ORM\OneToMany(targetEntity: UserCoursesStatus::class, mappedBy: 'user_id', cascade: ['persist', 'remove', 'merge', 'detach', 'refresh', 'all'], orphanRemoval: true)]
    private Collection $userCoursesStatuses;

    public function __construct() {
        $this->userCoursesStatuses = new ArrayCollection();
    }

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'email' => $this->getEmail(),
            'roles' => $this->getRoles(),
            'points' => $this->getPoints(),
            'image' => $this->getImage(),
            'userCoursesStatuses' => $this->getUserCoursesStatuses()->toArray()
        ];
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    /**
     * @see UserInterface
     *
     * @return list<string>
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): void
    {
        $this->roles = $roles;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getPoints(): ?int
    {
        return $this->points;
    }

    public function setPoints(int $points): void
    {
        $this->points = $points;
    }

    /**
     * @see UserInterface
     */
    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): void
    {
        $this->image = $image;
    }

    /**
     * @return Collection<int, UserCoursesStatus>
     */
    public function getUserCoursesStatuses(): Collection
    {
        return $this->userCoursesStatuses;
    }

    public function addUserCoursesStatus(UserCoursesStatus $userCoursesStatus): static
    {
        if (!$this->userCoursesStatuses->contains($userCoursesStatus)) {
            $this->userCoursesStatuses->add($userCoursesStatus);
            $userCoursesStatus->setUserId($this);
        }

        return $this;
    }

    public function removeUserCoursesStatus(UserCoursesStatus $userCoursesStatus): static
    {
        if ($this->userCoursesStatuses->removeElement($userCoursesStatus)) {
            // set the owning side to null (unless already changed)
            if ($userCoursesStatus->getUserId() === $this) {
                $userCoursesStatus->setUserId(null);
            }
        }

        return $this;
    }

    /**
     * @ORM\PrePersist
     */
    public function setStatusOnCreate(): void
    {
        // Set the default status for a newly created user
        // You can change this logic according to your requirements
        $defaultStatus = CoursesStatus::OPEN;

        // Create a UserCoursesStatus entity for the default status
        $userCoursesStatus = new UserCoursesStatus();
        $userCoursesStatus->setStatus($defaultStatus);

        // Associate the UserCoursesStatus entity with the current user
        $this->addUserCoursesStatus($userCoursesStatus);
    }
}
