<?php

namespace App\Service\TaskSolver\Strategy;

use App\Entity\Cell;
use App\Entity\Condition;
use App\Entity\Task;
use App\Enum\ConditionType;
use App\Enum\DecisionMakingMethod;

class ParetoStrategy implements SolverStrategyInterface
{
    private Task $task;

    public static function getName(): string
    {
        return DecisionMakingMethod::PARETO;
    }

    public function solve(Task $task): array
    {
        $this->task = $task;
        $matrixArr = $this->getMatrix();

        $alternativeMap = [];
        foreach ($task->getAlternatives() as $alternative) {
            $alternativeMap[$alternative->getId()] = $alternative;
        }

        $pareto = [];
        foreach ($matrixArr as $alternative1Id => $alternative1Data) {
            foreach ($matrixArr as $alternative2Id => $alternative2Data) {
                if ($this->isSurpasses($alternative2Data, $alternative1Data)) {
                    continue 2;
                }
            }
            $pareto[] = [
                'alternativeId' => $alternative1Id,
                'name' => $alternativeMap[$alternative1Id]->getName(),
            ];
        }

        return $pareto;
    }

    private function isSurpasses(array $alternative1, array $alternative2): bool
    {
        $oneGreater = false;
        $notLess = true;
        foreach ($alternative1 as $characteristicId => $value) {
            /** @var Condition $condition */
            $condition = $this->task->getConditions()->filter(fn(Condition $condition) => $condition->getCharacteristic()->getId() === $characteristicId)->first();

            if ($condition->getType() === ConditionType::MAX) {
                if ($value > $alternative2[$characteristicId]) {
                    $oneGreater = true;
                }

                if ($value < $alternative2[$characteristicId]) {
                    $notLess = false;
                }
            } else {
                if ($value < $alternative2[$characteristicId]) {
                    $oneGreater = true;
                }

                if ($value > $alternative2[$characteristicId]) {
                    $notLess = false;
                }
            }
        }

        return $oneGreater && $notLess;
    }

    private function getMatrix(): array
    {
        $matrixArr = [];
        /** @var Cell $cell */
        foreach ($this->task->getMatrix()->getCells() as $cell) {
            if (
                false === $this->task->getAlternatives()->contains($cell->getAlternative())
                || false === $this->task->getCharacteristics()->contains($cell->getCharacteristic())
            ) {
                continue;
            }
            // не может быть несколько значений
            $matrixArr[$cell->getAlternative()->getId()][$cell->getCharacteristic()->getId()] = $cell->getValues()->first()->getValue();
        }

        return $matrixArr;
    }
}
