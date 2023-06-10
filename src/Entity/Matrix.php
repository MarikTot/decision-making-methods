<?php

namespace App\Entity;

use App\Repository\MatrixRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ReadableCollection;
use Doctrine\ORM\Mapping as ORM;
use EasyCorp\Bundle\EasyAdminBundle\Config\Option\SortOrder;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Table(name: 'matrices')]
#[UniqueEntity(fields: ['title'])]
#[ORM\Index(columns: ['title'], name: 'matrix_title_idx')]
#[ORM\Entity(repositoryClass: MatrixRepository::class)]
class Matrix
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(length: 255)]
    private string $title;

    #[ORM\OrderBy(['id' => SortOrder::ASC])]
    #[ORM\OneToMany(mappedBy: 'matrix', targetEntity: MatrixAlternative::class)]
    private Collection $matrixAlternative;

    #[ORM\OrderBy(['id' => SortOrder::ASC])]
    #[ORM\OneToMany(mappedBy: 'matrix', targetEntity: MatrixCharacteristic::class)]
    private Collection $matrixCharacteristic;

    #[ORM\OneToMany(mappedBy: 'matrix', targetEntity: Cell::class, orphanRemoval: true)]
    private Collection $cells;

    #[ORM\OneToMany(mappedBy: 'matrix', targetEntity: Task::class)]
    private Collection $tasks;

    public function __construct()
    {
        $this->matrixAlternative = new ArrayCollection();
        $this->matrixCharacteristic = new ArrayCollection();
        $this->cells = new ArrayCollection();
        $this->tasks = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

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
     * @return Collection<int, Cell>
     */
    public function getCells(): Collection
    {
        return $this->cells;
    }

    public function addCell(Cell $cell): self
    {
        if (!$this->cells->contains($cell)) {
            $this->cells->add($cell);
            $cell->setMatrix($this);
        }

        return $this;
    }

    public function removeCell(Cell $cell): self
    {
        if ($this->cells->removeElement($cell)) {
            // set the owning side to null (unless already changed)
            if ($cell->getMatrix() === $this) {
                $cell->setMatrix(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return sprintf('%s (%s)', $this->getTitle(), $this->getId());
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
            $task->setMatrix($this);
        }

        return $this;
    }

    public function removeTask(Task $task): self
    {
        if ($this->tasks->removeElement($task)) {
            // set the owning side to null (unless already changed)
            if ($task->getMatrix() === $this) {
                $task->setMatrix(null);
            }
        }

        return $this;
    }

    public function allowToEdit(): bool
    {
        return $this->getTasks()->count() === 0;
    }
}
