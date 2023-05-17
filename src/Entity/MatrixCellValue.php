<?php

namespace App\Entity;

use App\Repository\MatrixCellValueRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MatrixCellValueRepository::class)]
class MatrixCellValue
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'matrixCellValues')]
    #[ORM\JoinColumn(nullable: false)]
    private ?MatrixCell $matrixCell = null;

    #[ORM\Column(length: 255)]
    private ?string $value = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMatrixCell(): ?MatrixCell
    {
        return $this->matrixCell;
    }

    public function setMatrixCell(?MatrixCell $matrixCell): self
    {
        $this->matrixCell = $matrixCell;

        return $this;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(string $value): self
    {
        $this->value = $value;

        return $this;
    }
}
