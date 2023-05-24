<?php

namespace App\Entity;

use App\Enum\MatrixConditionType;
use App\Repository\MatrixConditionRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: MatrixConditionRepository::class)]
class MatrixCondition
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\ManyToOne(inversedBy: 'matrixConditions')]
    #[ORM\JoinColumn(nullable: false)]
    private Matrix $matrix;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private Characteristic $characteristic;

    #[Assert\Choice([MatrixConditionType::MAX, MatrixConditionType::MIN])]
    #[ORM\Column(length: 50)]
    private string $type;

    public function getId(): int
    {
        return $this->id;
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

    public function getCharacteristic(): Characteristic
    {
        return $this->characteristic;
    }

    public function setCharacteristic(Characteristic $characteristic): self
    {
        $this->characteristic = $characteristic;

        return $this;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }
}
