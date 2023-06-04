<?php

namespace App\Dto;

use App\Entity\Type;
use App\Entity\TypeEnum;

class TypeDto
{
    private int $id;
    private string $name;
    private bool $isNumber;
    private bool $isDefaultType;
    private ?array $enum = null;

    public function __construct(Type $type)
    {
        $this->id = $type->getId();
        $this->name = $type->getName();
        $this->isNumber = $type->isNumber();
        $this->isDefaultType = $type->isDefaultType();

        /** @var TypeEnum $enum */
        foreach ($type->getTypeEnums() as $enum) {
            $this->enum[] = $enum->getValue();
        }
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'isNumber' => $this->isNumber,
            'isDefaultType' => $this->isDefaultType,
            'enum' => $this->enum,
        ];
    }
}
