<?php

namespace App\Entity;

use App\Repository\AlternativeRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[UniqueEntity(fields: ['name'])]
#[ORM\Index(columns: ['name'], name: 'alternative_name_idx')]
#[ORM\Table(name: 'alternatives')]
#[ORM\Entity(repositoryClass: AlternativeRepository::class)]
class Alternative implements AuditableInterface
{
    use AuditableTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(length: 255)]
    private string $name;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function __toString(): string
    {
        return sprintf('%s(%s)', $this->getName(), $this->getId());
    }
}
