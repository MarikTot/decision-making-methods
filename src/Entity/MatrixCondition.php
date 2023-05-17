<?php

namespace App\Entity;

use App\Repository\MatrixConditionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MatrixConditionRepository::class)]
class MatrixCondition
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'matrixConditions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Matrix $matrix = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Characteristic $characteristic = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getCharacteristic(): ?Characteristic
    {
        return $this->characteristic;
    }

    public function setCharacteristic(?Characteristic $characteristic): self
    {
        $this->characteristic = $characteristic;

        return $this;
    }
}
