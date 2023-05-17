<?php

namespace App\Entity;

use App\Repository\TaskRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'tasks')]
#[ORM\Entity(repositoryClass: TaskRepository::class)]
class Task
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\OneToMany(mappedBy: 'task', targetEntity: Matrix::class)]
    private Collection $matrices;

    public function __construct()
    {
        $this->matrices = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function __toString(): string
    {
        return sprintf('%s(%s)', $this->getTitle(), $this->getId());
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
            $matrix->setTask($this);
        }

        return $this;
    }

    public function removeMatrix(Matrix $matrix): self
    {
        if ($this->matrices->removeElement($matrix)) {
            // set the owning side to null (unless already changed)
            if ($matrix->getTask() === $this) {
                $matrix->setTask(null);
            }
        }

        return $this;
    }
}
