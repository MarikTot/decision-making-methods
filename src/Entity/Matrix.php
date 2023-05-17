<?php

namespace App\Entity;

use App\Repository\MatrixRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MatrixRepository::class)]
class Matrix
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'matrices')]
    private ?Task $task = null;

    #[ORM\ManyToMany(targetEntity: Alternative::class)]
    private Collection $alternatives;

    #[ORM\ManyToMany(targetEntity: Characteristic::class)]
    private Collection $characteristics;

    #[ORM\OneToMany(mappedBy: 'matrix', targetEntity: MatrixCondition::class, orphanRemoval: true)]
    private Collection $matrixConditions;

    #[ORM\OneToMany(mappedBy: 'matrix', targetEntity: MatrixCell::class, orphanRemoval: true)]
    private Collection $matrixCells;

    public function __construct()
    {
        $this->alternatives = new ArrayCollection();
        $this->characteristics = new ArrayCollection();
        $this->matrixConditions = new ArrayCollection();
        $this->matrixCells = new ArrayCollection();
    }

    public function getId(): ?int
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
}
