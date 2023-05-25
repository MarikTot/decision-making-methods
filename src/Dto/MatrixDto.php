<?php

namespace App\Dto;

use App\Entity\Alternative;
use App\Entity\Characteristic;
use App\Entity\Matrix;
use App\Entity\MatrixCell;
use App\Entity\MatrixCondition;
use App\Entity\MatrixDecision;

class MatrixDto
{
    private int $id;
    private array $characteristics = [];
    private array $alternatives = [];
    /** @var MatrixRowDto[] */
    private array $rows = [];
    /** @var MatrixCondition[] */
    private array $conditions = [];
    private array $decisions = [];

    public function __construct(
        private Matrix $matrix,
    ) {
        $this->id = $this->matrix->getId();

        $this->alternatives = $this->matrix
            ->getAlternatives()
            ->map(fn (Alternative $alternative) => new AlternativeDto($alternative))
            ->toArray()
        ;

        $this->characteristics = $this->matrix
            ->getCharacteristics()
            ->map(fn (Characteristic $characteristic) => new CharacteristicDto($characteristic))
            ->toArray()
        ;

        $alternativesMap = [];
        $table = [];
        /** @var Alternative $alternative */
        foreach ($this->matrix->getAlternatives() as $alternative) {
            $alternativesMap[$alternative->getId()] = $alternative;
            /** @var Characteristic $characteristic */
            foreach ($this->matrix->getCharacteristics() as $characteristic) {
                $table[$alternative->getId()][$characteristic->getId()] = null;
            }
        }

        /** @var MatrixCell $cell */
        foreach ($this->matrix->getMatrixCells() as $cell) {
            $table[$cell->getAlternative()->getId()][$cell->getCharacteristic()->getId()] = $cell;
        }

        foreach ($table as $alternativeId => $row) {
            $this->rows[] = new MatrixRowDto($alternativesMap[$alternativeId], array_values($row));
        }

        /** @var MatrixCondition $condition */
        foreach ($this->matrix->getMatrixConditions() as $condition) {
            $this->conditions[$condition->getCharacteristic()->getId()] = new MatrixConditionDto($condition);
        }

        /** @var MatrixDecision $condition */
        foreach ($this->matrix->getMatrixDecisions() as $decision) {
            $this->decisions[] = new MatrixDecisionDto($decision);
        }
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'alternatives' => array_map(fn (AlternativeDto $alternative) => $alternative->toArray(), $this->alternatives),
            'characteristics' => array_map(fn (CharacteristicDto $characteristic) => $characteristic->toArray(), $this->characteristics),
            'rows' => array_map(fn (MatrixRowDto $row) => $row->toArray(), $this->rows),
            'conditions' => array_map(fn (MatrixConditionDto $condition) => $condition->toArray(), $this->conditions),
            'decisions' => array_map(fn (MatrixDecisionDto $decision) => $decision->toArray(), $this->decisions),
        ];
    }
}
