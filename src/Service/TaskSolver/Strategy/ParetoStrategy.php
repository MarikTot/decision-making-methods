<?php

namespace App\Service\TaskSolver\Strategy;

use App\Entity\Alternative;
use App\Entity\Cell;
use App\Entity\Condition;
use App\Entity\Task;
use App\Enum\ConditionType;
use App\Enum\DecisionMakingMethod;

class ParetoStrategy implements SolverStrategyInterface
{

    public static function getName(): string
    {
        return DecisionMakingMethod::PARETO;
    }

    public function solve(Task $task): array
    {
        $matrixArr = $this->getMatrix($task);

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
            if ($value > $alternative2[$characteristicId]) {
                $oneGreater = true;
            }

            if ($value < $alternative2[$characteristicId]) {
                $notLess = false;
            }
        }

        return $oneGreater && $notLess;
    }

    private function getMatrix(Task $task)
    {
        $matrixArr = [];
        /** @var Cell $cell */
        foreach ($task->getMatrix()->getCells() as $cell) {
            if (
                false === $task->getAlternatives()->contains($cell->getAlternative())
                || false === $task->getCharacteristics()->contains($cell->getCharacteristic())
            ) {
                continue;
            }
            // не может быть несколько значений
            $matrixArr[$cell->getAlternative()->getId()][$cell->getCharacteristic()->getId()] = $cell->getValues()->first()->getValue();
        }

        return $matrixArr;
    }
}
