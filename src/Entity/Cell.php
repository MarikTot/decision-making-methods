<?php

namespace App\Entity;

use App\Repository\CellRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Table(name: 'cells')]
#[UniqueEntity(
    fields: ['alternative', 'characteristic', 'matrix'],
    message: 'Такая ячейка уже есть',
)]
#[ORM\Index(columns: ['matrix_id', 'alternative_id', 'characteristic_id'], name: 'cell_matrix_alternative_characteristic_idx')]
#[ORM\Entity(repositoryClass: CellRepository::class)]
class Cell
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(name: 'alternative_id')]
    private int $alternativeId;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private Alternative $alternative;

    #[ORM\Column(name: 'characteristic_id')]
    private int $characteristicId;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private Characteristic $characteristic;

    #[ORM\Column(name: 'matrix_id')]
    private int $matrixId;

    #[ORM\ManyToOne(inversedBy: 'cells')]
    #[ORM\JoinColumn(nullable: false)]
    private Matrix $matrix;

    #[ORM\OneToMany(mappedBy: 'cell', targetEntity: Value::class, orphanRemoval: true)]
    private Collection $values;

    public function __construct()
    {
        $this->values = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getAlternative(): Alternative
    {
        return $this->alternative;
    }

    public function setAlternative(Alternative $alternative): self
    {
        $this->alternative = $alternative;

        return $this;
    }

    public function getCharacteristic(): Characteristic
    {
        return $this->characteristic;
    }

    public function setCharacteristic(Characteristic $characteristic): self
    {
        $this->characteristic = $characteristic;

        return $this;
    }

    public function getMatrix(): Matrix
    {
        return $this->matrix;
    }

    public function setMatrix(Matrix $matrix): self
    {
        $this->matrix = $matrix;

        return $this;
    }

    /**
     * @return Collection<int, Value>
     */
    public function getValues(): Collection
    {
        return $this->values;
    }

    public function addValue(Value $value): self
    {
        if (!$this->values->contains($value)) {
            $this->values->add($value);
            $value->setCell($this);
        }

        return $this;
    }

    public function removeValue(Value $value): self
    {
        if ($this->values->removeElement($value)) {
            // set the owning side to null (unless already changed)
            if ($value->getCell() === $this) {
                $value->setCell(null);
            }
        }

        return $this;
    }
}
