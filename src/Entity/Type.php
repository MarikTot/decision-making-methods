<?php

namespace App\Entity;

use App\Repository\TypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Types\Boolean;

#[ORM\Table(name: 'types')]
#[ORM\Entity(repositoryClass: TypeRepository::class)]
class Type
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(length: 255)]
    private string $name;

    #[ORM\Column(options: ['default' => false])]
    private bool $isNumber = false;

    #[ORM\OneToMany(mappedBy: 'type', targetEntity: Characteristic::class)]
    private Collection $characteristics;

    #[ORM\OneToMany(mappedBy: 'type', targetEntity: TypeEnum::class)]
    private Collection $typeEnums;

    #[ORM\Column(options: ['default' => false])]
    private bool $defaultType = false;

    public function __construct()
    {
        $this->characteristics = new ArrayCollection();
        $this->typeEnums = new ArrayCollection();
    }

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

    public function isNumber(): bool
    {
        return $this->isNumber;
    }

    public function setIsNumber(bool $isNumber): self
    {
        $this->isNumber = $isNumber;

        return $this;
    }

    /**
     * @return Collection<int, Characteristic>
     */
    public function getCharacteristics(): Collection
    {
        return $this->characteristics;
    }

    public function addCharacteristic(Characteristic $characteristic): self
    {
        if (!$this->characteristics->contains($characteristic)) {
            $this->characteristics->add($characteristic);
            $characteristic->setType($this);
        }

        return $this;
    }

    public function removeCharacteristic(Characteristic $characteristic): self
    {
        if ($this->characteristics->removeElement($characteristic)) {
            // set the owning side to null (unless already changed)
            if ($characteristic->getType() === $this) {
                $characteristic->setType(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, TypeEnum>
     */
    public function getTypeEnums(): Collection
    {
        return $this->typeEnums;
    }

    public function addTypeEnum(TypeEnum $typeEnum): self
    {
        if (!$this->typeEnums->contains($typeEnum)) {
            $this->typeEnums->add($typeEnum);
            $typeEnum->setType($this);
        }

        return $this;
    }

    public function removeTypeEnum(TypeEnum $typeEnum): self
    {
        if ($this->typeEnums->removeElement($typeEnum)) {
            // set the owning side to null (unless already changed)
            if ($typeEnum->getType() === $this) {
                $typeEnum->setType(null);
            }
        }

        return $this;
    }

    public function isDefaultType(): bool
    {
        return $this->defaultType;
    }

    public function setDefaultType(bool $defaultType): self
    {
        $this->defaultType = $defaultType;

        return $this;
    }

    public function __toString(): string
    {
        return sprintf('%s', $this->getName());
    }
}
