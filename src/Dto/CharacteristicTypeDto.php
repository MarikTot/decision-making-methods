<?php

namespace App\Dto;

use App\Entity\CharacteristicType;
use App\Entity\CharacteristicTypeEnum;

class CharacteristicTypeDto
{
    private string $name;
    private ?array $enum = null;

    public function __construct(CharacteristicType $type)
    {
        $this->name = $type->getName();

        /** @var CharacteristicTypeEnum $enum */
        foreach ($type->getCharacteristicTypeEnums() as $enum) {
            $this->enum[] = $enum->getValue();
        }
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'enum' => $this->enum,
        ];
    }
}
