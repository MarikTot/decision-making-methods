<?php

namespace App\Entity;

use App\Repository\MatrixCellRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[UniqueEntity(
    fields: ['alternative', 'characteristic', 'matrix'],
    message: 'Такая ячейка уже есть',
)]
#[ORM\Index(columns: ['matrix_id', 'alternative_id', 'characteristic_id'], name: 'matrix_alternative_characteristic_idx')]
#[ORM\Entity(repositoryClass: MatrixCellRepository::class)]
class MatrixCell
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

    #[ORM\ManyToOne(inversedBy: 'matrixCells')]
    #[ORM\JoinColumn(nullable: false)]
    private Matrix $matrix;

    #[ORM\OneToMany(mappedBy: 'matrixCell', targetEntity: MatrixCellValue::class, orphanRemoval: true)]
    private Collection $matrixCellValues;

    public function __construct()
    {
        $this->matrixCellValues = new ArrayCollection();
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
     * @return Collection<int, MatrixCellValue>
     */
    public function getMatrixCellValues(): Collection
    {
        return $this->matrixCellValues;
    }

    public function addMatrixCellValue(MatrixCellValue $matrixCellValue): self
    {
        if (!$this->matrixCellValues->contains($matrixCellValue)) {
            $this->matrixCellValues->add($matrixCellValue);
            $matrixCellValue->setMatrixCell($this);
        }

        return $this;
    }

    public function removeMatrixCellValue(MatrixCellValue $matrixCellValue): self
    {
        if ($this->matrixCellValues->removeElement($matrixCellValue)) {
            // set the owning side to null (unless already changed)
            if ($matrixCellValue->getMatrixCell() === $this) {
                $matrixCellValue->setMatrixCell(null);
            }
        }

        return $this;
    }
}
