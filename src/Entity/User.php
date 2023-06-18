<?php

namespace App\Entity;

use App\Enum\UserRole;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
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

    #[Assert\Length(min: 4, max: 180)]
    #[Assert\Regex('/^\w+$/')]
    #[ORM\Column(length: 180, unique: true)]
    private string $username;

    #[ORM\Column]
    private array $roles = [];

    #[ORM\Column]
    private ?string $password = null;

    #[ORM\OneToMany(mappedBy: 'createdBy', targetEntity: Result::class)]
    private Collection $results;

    #[ORM\OneToMany(mappedBy: 'createdBy', targetEntity: Task::class)]
    private Collection $tasks;

    #[ORM\OneToMany(mappedBy: 'createdBy', targetEntity: Matrix::class)]
    private Collection $matrices;

    #[Assert\Length(min: 2, max: 180)]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $firstname = null;

    #[Assert\Length(min: 2, max: 180)]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $lastname = null;

    public function __construct()
    {
        $this->results = new ArrayCollection();
        $this->tasks = new ArrayCollection();
        $this->matrices = new ArrayCollection();
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
        return (string) $this->getId();
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
     * @return Collection<int, Result>
     */
    public function getResults(): Collection
    {
        return $this->results;
    }

    public function addResult(Result $result): self
    {
        if (!$this->results->contains($result)) {
            $this->results->add($result);
            $result->setCreatedBy($this);
        }

        return $this;
    }

    public function removeResult(Result $result): self
    {
        if ($this->results->removeElement($result)) {
            // set the owning side to null (unless already changed)
            if ($result->getCreatedBy() === $this) {
                $result->setCreatedBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Task>
     */
    public function getTasks(): Collection
    {
        return $this->tasks;
    }

    public function addTask(Task $task): self
    {
        if (!$this->tasks->contains($task)) {
            $this->tasks->add($task);
            $task->setCreatedBy($this);
        }

        return $this;
    }

    public function removeTask(Task $task): self
    {
        if ($this->tasks->removeElement($task)) {
            // set the owning side to null (unless already changed)
            if ($task->getCreatedBy() === $this) {
                $task->setCreatedBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Matrix>
     */
    public function getMatrices(): Collection
    {
        return $this->matrices;
    }

    public function addMatrix(Matrix $matrix): self
    {
        if (!$this->matrices->contains($matrix)) {
            $this->matrices->add($matrix);
            $matrix->setCreatedBy($this);
        }

        return $this;
    }

    public function removeMatrix(Matrix $matrix): self
    {
        if ($this->matrices->removeElement($matrix)) {
            // set the owning side to null (unless already changed)
            if ($matrix->getCreatedBy() === $this) {
                $matrix->setCreatedBy(null);
            }
        }

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(?string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(?string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function __toString(): string
    {
        $fullName = sprintf('%s %s', $this->getFirstname(), $this->getLastname());
        $fullName = trim($fullName);

        return $fullName ?: $this->getUsername();
    }
}
