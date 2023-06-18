<?php

namespace App\Entity;

use App\Repository\TypeEnumRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'type_enums')]
#[ORM\Entity(repositoryClass: TypeEnumRepository::class)]
class TypeEnum implements AuditableInterface
{
    use AuditableTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(length: 255)]
    private ?string $value = null;

    #[ORM\ManyToOne(inversedBy: 'typeEnums')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Type $type = null;

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

    public function getType(): ?Type
    {
        return $this->type;
    }

    public function setType(?Type $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function __toString(): string
    {
        return $this->getValue();
    }
}
