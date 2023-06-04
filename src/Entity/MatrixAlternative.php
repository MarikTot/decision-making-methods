<?php

namespace App\Entity;

use App\Repository\MatrixAlternativeRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[UniqueEntity(fields: ['matrix', 'alternative'], errorPath: 'alternative')]
#[ORM\HasLifecycleCallbacks]
#[ORM\Index(columns: ['matrix_id', 'alternative_id'], name: 'matrix_alternative_idx')]
#[ORM\Entity(repositoryClass: MatrixAlternativeRepository::class)]
class MatrixAlternative
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\ManyToOne(inversedBy: 'matrixAlternative')]
    #[ORM\JoinColumn(nullable: false)]
    private Matrix $matrix;

    #[ORM\ManyToOne(targetEntity: Alternative::class)]
    #[ORM\JoinColumn(nullable: false)]
    private Alternative $alternative;

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

    public function getAlternative(): Alternative
    {
        return $this->alternative;
    }

    public function setAlternative(Alternative $alternative): self
    {
        $this->alternative = $alternative;

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
            $this->getAlternative()->getName(),
        );
    }
}
