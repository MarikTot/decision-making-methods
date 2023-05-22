<?php

namespace App\Entity;

use App\Repository\CharacteristicTypeEnumRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CharacteristicTypeEnumRepository::class)]
class CharacteristicTypeEnum
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(length: 255)]
    private ?string $value = null;

    #[ORM\ManyToOne(inversedBy: 'characteristicTypeEnums')]
    #[ORM\JoinColumn(nullable: false)]
    private ?CharacteristicType $type = null;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

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
        return $this->getValue();
    }
}
