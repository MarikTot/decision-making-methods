<?php

namespace App\Dto;

use App\Entity\Characteristic;
use App\Entity\MatrixCell;

class CharacteristicCellsDto
{
    public function __construct(
        private Characteristic $characteristic,
        /** @var MatrixCell[] */
        private array $cells,
    ) {
    }

    public function getCharacteristic(): Characteristic
    {
        return $this->characteristic;
    }

    public function getCells(): array
    {
        return $this->cells;
    }
}
