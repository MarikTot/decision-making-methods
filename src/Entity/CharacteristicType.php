<?php

namespace App\Entity;

use App\Repository\CharacteristicTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CharacteristicTypeRepository::class)]
class CharacteristicType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(length: 255)]
    private string $name;

    #[ORM\OneToMany(mappedBy: 'type', targetEntity: Characteristic::class)]
    private Collection $characteristics;

    #[ORM\OneToMany(mappedBy: 'type', targetEntity: CharacteristicTypeEnum::class)]
    private Collection $characteristicTypeEnums;

    #[ORM\Column(options: ['default' => false])]
    private bool $defaultType = false;

    public function __construct()
    {
        $this->characteristics = new ArrayCollection();
        $this->characteristicTypeEnums = new ArrayCollection();
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
     * @return Collection<int, CharacteristicTypeEnum>
     */
    public function getCharacteristicTypeEnums(): Collection
    {
        return $this->characteristicTypeEnums;
    }

    public function addCharacteristicTypeEnum(CharacteristicTypeEnum $characteristicTypeEnum): self
    {
        if (!$this->characteristicTypeEnums->contains($characteristicTypeEnum)) {
            $this->characteristicTypeEnums->add($characteristicTypeEnum);
            $characteristicTypeEnum->setType($this);
        }

        return $this;
    }

    public function removeCharacteristicTypeEnum(CharacteristicTypeEnum $characteristicTypeEnum): self
    {
        if ($this->characteristicTypeEnums->removeElement($characteristicTypeEnum)) {
            // set the owning side to null (unless already changed)
            if ($characteristicTypeEnum->getType() === $this) {
                $characteristicTypeEnum->setType(null);
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
