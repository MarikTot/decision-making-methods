<?php

namespace App\Dto;

use App\Entity\Alternative;
use App\Entity\Characteristic;
use App\Entity\Matrix;
use App\Entity\Cell;
use App\Entity\Task;
use Doctrine\Common\Collections\ReadableCollection;

class MatrixDto
{
    private int $id;
    private array $characteristics = [];
    private array $alternatives = [];
    private array $table = [];

    public function __construct(
        private Matrix $matrix,
        private ?Task $task = null,
    ) {
        $this->defineId();
        $this->defineAlternatives();
        $this->defineCharacteristics();
        $this->defineTable();
    }

    private function defineId(): void
    {
        $this->id = $this->matrix->getId();
    }

    private function defineAlternatives(): void
    {
        $alternatives = $this->getFilteredAlternatives();

        $this->alternatives = $alternatives
            ->map(fn(Alternative $alternative) => new AlternativeDto($alternative))
            ->toArray();
    }

    private function defineCharacteristics(): void
    {
        $characteristics = $this->getFilteredCharacteristics();

        $this->characteristics = $characteristics
            ->map(fn(Characteristic $characteristic) => new CharacteristicDto($characteristic))
            ->toArray();
    }

    private function defineTable(): void
    {
        $alternatives = $this->getFilteredAlternatives();
        $characteristics = $this->getFilteredCharacteristics();

        /** @var Alternative $alternative */
        foreach ($alternatives as $alternative) {
            /** @var Characteristic $characteristic */
            foreach ($characteristics as $characteristic) {
                $this->table[$alternative->getName()][$characteristic->getName()] = null;
            }
        }

        /** @var Cell $cell */
        foreach ($this->matrix->getCells() as $cell) {
            if (
                false === $alternatives->contains($cell->getAlternative())
                || false === $characteristics->contains($cell->getCharacteristic())
            ) {
                continue;
            }
            $this->table[$cell->getAlternative()->getName()][$cell->getCharacteristic()->getName()] = new CellDto($cell);
        }
    }

    private function getFilteredAlternatives(): ReadableCollection
    {
        $alternatives = $this->matrix->getAlternatives();

        if (null !== $this->task) {
            $alternatives = $alternatives
                ->filter(fn(Alternative $alternative) => $this->task->getAlternatives()->contains($alternative));
        }

        return $alternatives;
    }

    private function getFilteredCharacteristics(): ReadableCollection
    {
        $characteristics = $this->matrix->getCharacteristics();

        if (null !== $this->task) {
            $characteristics = $characteristics
                ->filter(fn(Characteristic $characteristic) => $this->task->getCharacteristics()->contains($characteristic));
        }

        return $characteristics;
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
