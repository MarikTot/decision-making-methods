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

    #[ORM\OneToMany(mappedBy: 'task', targetEntity: Result::class, cascade: ['remove'])]
    private Collection $results;

    #[ORM\ManyToOne(inversedBy: 'tasks')]
    private ?Matrix $matrix = null;

    #[ORM\ManyToMany(targetEntity: Alternative::class)]
    private Collection $alternatives;

    #[ORM\ManyToMany(targetEntity: Characteristic::class)]
    private Collection $characteristics;

    #[ORM\OneToMany(mappedBy: 'task', targetEntity: Condition::class, cascade: ['remove'])]
    private Collection $conditions;

    public function __construct()
    {
        $this->results = new ArrayCollection();
        $this->alternatives = new ArrayCollection();
        $this->characteristics = new ArrayCollection();
        $this->conditions = new ArrayCollection();
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
            $result->setTask($this);
        }

        return $this;
    }

    public function removeResult(Result $result): self
    {
        if ($this->results->removeElement($result)) {
            // set the owning side to null (unless already changed)
            if ($result->getTask() === $this) {
                $result->setTask(null);
            }
        }

        return $this;
    }

    public function getMatrix(): ?Matrix
    {
        return $this->matrix;
    }

    public function setMatrix(?Matrix $matrix): self
    {
        $this->matrix = $matrix;

        return $this;
    }

    /**
     * @return Collection<int, Alternative>
     */
    public function getAlternatives(): Collection
    {
        return $this->alternatives;
    }

    public function addAlternative(Alternative $alternative): self
    {
        if (!$this->alternatives->contains($alternative)) {
            $this->alternatives->add($alternative);
        }

        return $this;
    }

    public function removeAlternative(Alternative $alternative): self
    {
        $this->alternatives->removeElement($alternative);

        return $this;
    }

    /**
     * @return Collection<int, Characteristic>
     */
    public function getCharacteristics(): Collection
    {
        return $this->characteristics;
    }

    public function addCharacteristic(Characteristic $characteristic): self
    {
        if (!$this->characteristics->contains($characteristic)) {
            $this->characteristics->add($characteristic);
        }

        return $this;
    }

    public function removeCharacteristic(Characteristic $characteristic): self
    {
        $this->characteristics->removeElement($characteristic);

        return $this;
    }

    /**
     * @return Collection<int, Condition>
     */
    public function getConditions(): Collection
    {
        return $this->conditions;
    }

    public function addCondition(Condition $condition): self
    {
        if (!$this->conditions->contains($condition)) {
            $this->conditions->add($condition);
            $condition->setTask($this);
        }

        return $this;
    }

    public function removeCondition(Condition $condition): self
    {
        if ($this->conditions->removeElement($condition)) {
            // set the owning side to null (unless already changed)
            if ($condition->getTask() === $this) {
                $condition->setTask(null);
            }
        }

        return $this;
    }
}
