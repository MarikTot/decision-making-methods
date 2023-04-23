<?php

namespace App\Entity;

use App\Repository\CharacteristicRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'characteristics')]
#[ORM\Entity(repositoryClass: CharacteristicRepository::class)]
class Characteristic
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?bool $multiple = null;

    #[ORM\ManyToOne(inversedBy: 'characteristics')]
    #[ORM\JoinColumn(nullable: false)]
    private ?CharacteristicType $type = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function isMultiple(): ?bool
    {
        return $this->multiple;
    }

    public function setMultiple(bool $multiple): self
    {
        $this->multiple = $multiple;

        return $this;
    }

    public function getType(): ?CharacteristicType
    {
        return $this->type;
    }

    public function setType(?CharacteristicType $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function __toString(): string
    {
        return sprintf('%s(%s)', $this->getName(), $this->getId());
    }
}
