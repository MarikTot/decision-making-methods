<?php

namespace App\Entity;

use App\Enum\UserRole;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`users`')]
#[UniqueEntity(fields: ['username'], message: 'Пользователь с таким именем уже существует')]
#[ORM\HasLifecycleCallbacks]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private string $username;

    #[ORM\Column]
    private array $roles = [];

    #[ORM\Column]
    private ?string $password = null;

    #[ORM\OneToMany(mappedBy: 'createdBy', targetEntity: MatrixDecision::class)]
    private Collection $matrixDecisions;

    public function __construct()
    {
        $this->matrixDecisions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

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
        return $this->roles;
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

    #[ORM\PreUpdate]
    public function onUpdate(): void
    {
        if ($this->getRoles() === []) {
            $this->setRoles([
                UserRole::USER,
            ]);
        }
    }

    #[ORM\PrePersist]
    public function onSave(): void
    {
        if ($this->getRoles() === []) {
            $this->setRoles([
                UserRole::USER,
            ]);
        }
    }

    /**
     * @return Collection<int, MatrixDecision>
     */
    public function getMatrixDecisions(): Collection
    {
        return $this->matrixDecisions;
    }

    public function addMatrixDecision(MatrixDecision $matrixDecision): self
    {
        if (!$this->matrixDecisions->contains($matrixDecision)) {
            $this->matrixDecisions->add($matrixDecision);
            $matrixDecision->setCreatedBy($this);
        }

        return $this;
    }

    public function removeMatrixDecision(MatrixDecision $matrixDecision): self
    {
        if ($this->matrixDecisions->removeElement($matrixDecision)) {
            // set the owning side to null (unless already changed)
            if ($matrixDecision->getCreatedBy() === $this) {
                $matrixDecision->setCreatedBy(null);
            }
        }

        return $this;
    }
}
