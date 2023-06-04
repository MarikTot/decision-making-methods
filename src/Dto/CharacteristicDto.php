<?php

namespace App\Dto;

use App\Entity\Characteristic;

class CharacteristicDto
{
    private int $id;
    private string $name;
    private bool $multiple;
    private TypeDto $type;

    public function __construct(Characteristic $characteristic)
    {
        $this->id = $characteristic->getId();
        $this->name = $characteristic->getName();
        $this->multiple = $characteristic->isMultiple();

        $this->type = new TypeDto($characteristic->getType());
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'multiple' => $this->multiple,
            'type' => $this->type->toArray(),
        ];
    }
}
