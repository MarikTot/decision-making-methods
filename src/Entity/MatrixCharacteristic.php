<?php

namespace App\Entity;

use App\Repository\MatrixCharacteristicRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[UniqueEntity(fields: ['matrix', 'characteristic'], errorPath: 'characteristic')]
#[ORM\HasLifecycleCallbacks]
#[ORM\Index(columns: ['matrix_id', 'characteristic_id'], name: 'matrix_characteristic_idx')]
#[ORM\Entity(repositoryClass: MatrixCharacteristicRepository::class)]
class MatrixCharacteristic
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\ManyToOne(inversedBy: 'matrixCharacteristic')]
    #[ORM\JoinColumn(nullable: false)]
    private Matrix $matrix;

    #[ORM\ManyToOne(targetEntity: Characteristic::class)]
    #[ORM\JoinColumn(nullable: false)]
    private Characteristic $characteristic;

    #[ORM\Column]
    private DateTimeImmutable $createdAt;

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

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    #[ORM\PrePersist]
    public function onSave(): void
    {
        $this->setCreatedAt(new DateTimeImmutable());
    }

    public function __toString(): string
    {
        return sprintf(
            '%s',
            $this->getCharacteristic()->getName(),
        );
    }
}
