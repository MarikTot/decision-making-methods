<?php

namespace App\Dto;

use App\Entity\MatrixCell;
use App\Entity\MatrixCellValue;

class MatrixCellDto
{
    private int $id;
    private AlternativeDto $alternative;
    private CharacteristicDto $characteristic;
    private mixed $value;

    public function __construct(MatrixCell $cell)
    {
        $this->id = $cell->getId();
        $this->alternative = new AlternativeDto($cell->getAlternative());
        $this->characteristic = new CharacteristicDto($cell->getCharacteristic());
        $this->value = $this->parseValue($cell);
    }

    private function parseValue(MatrixCell $cell): mixed
    {
        $value = [];
        /** @var MatrixCellValue $cellValue */
        foreach ($cell->getMatrixCellValues() as $cellValue) {
            $value[] = $cellValue->getValue();
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
