<?php

namespace App\Dto;

use App\Entity\Alternative;
use App\Entity\Characteristic;
use App\Entity\Matrix;
use App\Entity\Cell;

class MatrixDto
{
    private int $id;
    private array $characteristics = [];
    private array $alternatives = [];
    private array $table = [];

    public function __construct(
        private Matrix $matrix,
    )
    {
        $this->id = $this->matrix->getId();

        $this->alternatives = $this->matrix
            ->getAlternatives()
            ->map(fn(Alternative $alternative) => new AlternativeDto($alternative))
            ->toArray();

        $this->characteristics = $this->matrix
            ->getCharacteristics()
            ->map(fn(Characteristic $characteristic) => new CharacteristicDto($characteristic))
            ->toArray();

        /** @var Alternative $alternative */
        foreach ($this->matrix->getAlternatives() as $alternative) {
            /** @var Characteristic $characteristic */
            foreach ($this->matrix->getCharacteristics() as $characteristic) {
                $this->table[$alternative->getName()][$characteristic->getName()] = null;
            }
        }

        /** @var Cell $cell */
        foreach ($this->matrix->getCells() as $cell) {
            $this->table[$cell->getAlternative()->getName()][$cell->getCharacteristic()->getName()] = new CellDto($cell);
        }
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'alternatives' => array_map(fn(AlternativeDto $alternative) => $alternative->toArray(), $this->alternatives),
            'characteristics' => array_map(fn(CharacteristicDto $characteristic) => $characteristic->toArray(), $this->characteristics),
            'table' => array_map(fn(array $row) => array_map(fn(CellDto $dto) => $dto->toArray(), $row), $this->table),
        ];
    }
}
