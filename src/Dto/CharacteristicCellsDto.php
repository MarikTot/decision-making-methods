<?php

namespace App\Dto;

use App\Entity\Characteristic;
use App\Entity\Cell;

class CharacteristicCellsDto
{
    public function __construct(
        private Characteristic $characteristic,
        /** @var Cell[] */
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
