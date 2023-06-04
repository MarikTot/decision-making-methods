<?php

namespace App\Dto;

use App\Entity\Cell;
use App\Entity\Value;

class CellDto
{
    private int $id;
    private AlternativeDto $alternative;
    private CharacteristicDto $characteristic;
    private mixed $value;

    public function __construct(Cell $cell)
    {
        $this->id = $cell->getId();
        $this->alternative = new AlternativeDto($cell->getAlternative());
        $this->characteristic = new CharacteristicDto($cell->getCharacteristic());
        $this->value = $this->parseValue($cell);
    }

    private function parseValue(Cell $cell): mixed
    {
        $value = [];
        /** @var Value $valueObj */
        foreach ($cell->getValues() as $valueObj) {
            $value[] = $valueObj->getValue();
        }

        if (false === $cell->getCharacteristic()->isMultiple()) {
            $value = array_shift($value) ?: null;
        }

        return $value;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'alternative' => $this->alternative->toArray(),
            'characteristic' => $this->characteristic->toArray(),
            'value' => $this->value,
        ];
    }
}
