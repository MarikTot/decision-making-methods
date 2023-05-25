<?php

namespace App\Entity;

use App\Repository\MatrixRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ReadableCollection;
use Doctrine\ORM\Mapping as ORM;
use EasyCorp\Bundle\EasyAdminBundle\Config\Option\SortOrder;

#[ORM\Entity(repositoryClass: MatrixRepository::class)]
class Matrix
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\ManyToOne(inversedBy: 'matrices')]
    private ?Task $task = null;

    #[ORM\OrderBy(['createdAt' => SortOrder::ASC])]
    #[ORM\OneToMany(mappedBy: 'matrix', targetEntity: MatrixAlternative::class)]
    private Collection $matrixAlternative;

    #[ORM\OrderBy(['createdAt' => SortOrder::ASC])]
    #[ORM\OneToMany(mappedBy: 'matrix', targetEntity: MatrixCharacteristic::class)]
    private Collection $matrixCharacteristic;

    #[ORM\OneToMany(mappedBy: 'matrix', targetEntity: MatrixCondition::class, orphanRemoval: true)]
    private Collection $matrixConditions;

    #[ORM\OneToMany(mappedBy: 'matrix', targetEntity: MatrixCell::class, orphanRemoval: true)]
    private Collection $matrixCells;

    #[ORM\OneToMany(mappedBy: 'matrix', targetEntity: MatrixDecision::class)]
    private Collection $matrixDecisions;

    public function __construct()
    {
        $this->matrixAlternative = new ArrayCollection();
        $this->matrixCharacteristic = new ArrayCollection();
        $this->matrixConditions = new ArrayCollection();
        $this->matrixCells = new ArrayCollection();
        $this->matrixDecisions = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getTask(): ?Task
    {
        return $this->task;
    }

    public function setTask(?Task $task): self
    {
        $this->task = $task;

        return $this;
    }

    /**
     * @return Collection
     */
    public function getMatrixAlternative(): Collection
    {
        return $this->matrixAlternative;
    }

    /**
     * @return ReadableCollection<int, Alternative>
     */
    public function getAlternatives(): ReadableCollection
    {
        return $this->getMatrixAlternative()->map(fn(MatrixAlternative $ma) => $ma->getAlternative());
    }

    public function addMatrixAlternative(MatrixAlternative $ma): self
    {
        if (!$this->matrixAlternative->contains($ma)) {
            $this->matrixAlternative->add($ma);
            $ma->setMatrix($this);
        }

        return $this;
    }

    public function removeMatrixAlternative(MatrixAlternative $ma): self
    {
        $this->matrixAlternative->removeElement($ma);

        return $this;
    }

    /**
     * @return ReadableCollection<int, Characteristic>
     */
    public function getCharacteristics(): ReadableCollection
    {
        return $this->getMatrixCharacteristic()->map(fn(MatrixCharacteristic $mc) => $mc->getCharacteristic());
    }

    /**
     * @return Collection<int, MatrixCharacteristic>
     */
    public function getMatrixCharacteristic(): Collection
    {
        return $this->matrixCharacteristic;
    }

    public function addMatrixCharacteristic(MatrixCharacteristic $matrixCharacteristic): self
    {
        if (!$this->matrixCharacteristic->contains($matrixCharacteristic)) {
            $this->matrixCharacteristic->add($matrixCharacteristic);
            $matrixCharacteristic->setMatrix($this);
        }

        return $this;
    }

    public function removeMatrixCharacteristic(MatrixCharacteristic $matrixCharacteristic): self
    {
        $this->matrixCharacteristic->removeElement($matrixCharacteristic);

        return $this;
    }

    /**
     * @return Collection<int, MatrixCondition>
     */
    public function getMatrixConditions(): Collection
    {
        return $this->matrixConditions;
    }

    public function addMatrixCondition(MatrixCondition $matrixCondition): self
    {
        if (!$this->matrixConditions->contains($matrixCondition)) {
            $this->matrixConditions->add($matrixCondition);
            $matrixCondition->setMatrix($this);
        }

        return $this;
    }

    public function removeMatrixCondition(MatrixCondition $matrixCondition): self
    {
        if ($this->matrixConditions->removeElement($matrixCondition)) {
            // set the owning side to null (unless already changed)
            if ($matrixCondition->getMatrix() === $this) {
                $matrixCondition->setMatrix(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, MatrixCell>
     */
    public function getMatrixCells(): Collection
    {
        return $this->matrixCells;
    }

    public function addMatrixCell(MatrixCell $matrixCell): self
    {
        if (!$this->matrixCells->contains($matrixCell)) {
            $this->matrixCells->add($matrixCell);
            $matrixCell->setMatrix($this);
        }

        return $this;
    }

    public function removeMatrixCell(MatrixCell $matrixCell): self
    {
        if ($this->matrixCells->removeElement($matrixCell)) {
            // set the owning side to null (unless already changed)
            if ($matrixCell->getMatrix() === $this) {
                $matrixCell->setMatrix(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return sprintf('%s(%s)', $this->getId(), $this->getTask()->getTitle());
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
            $matrixDecision->setMatrix($this);
        }

        return $this;
    }

    public function removeMatrixDecision(MatrixDecision $matrixDecision): self
    {
        if ($this->matrixDecisions->removeElement($matrixDecision)) {
            // set the owning side to null (unless already changed)
            if ($matrixDecision->getMatrix() === $this) {
                $matrixDecision->setMatrix(null);
            }
        }

        return $this;
    }
}
