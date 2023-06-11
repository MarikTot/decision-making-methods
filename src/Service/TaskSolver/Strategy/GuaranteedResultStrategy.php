<?php

namespace App\Service\TaskSolver\Strategy;

use App\Entity\Cell;
use App\Entity\Condition;
use App\Entity\Task;
use App\Enum\ConditionType;
use App\Enum\DecisionMakingMethod;

class GuaranteedResultStrategy implements SolverStrategyInterface
{
    public static function getName(): string
    {
        return DecisionMakingMethod::GUARANTEED_RESULT;
    }

    public function solve(Task $task): array
    {
        $alternativeMap = [];
        foreach ($task->getAlternatives() as $alternative) {
            $alternativeMap[$alternative->getId()] = $alternative;
        }

        $matrixArr = $this->normalize($task);

        /**
         * 3. находим худшее значение по каждой
         * 4. располагам по убыванию
         */

        $result = [];
        foreach ($matrixArr as $alternativeId => $data) {
            $result[] = [
                'alternativeId' => $alternativeId,
                'name' => $alternativeMap[$alternativeId]->getName(),
                'value' => min($data),
            ];
        }

        usort($result, fn($data1, $data2) => $data2['value'] <=> $data1['value']);

        return $result;
    }

    /**
     * 2. "нормализуем ее" на основе макс мин
     */
    private function normalize(Task $task): array
    {
        $charTypeMap = [];
        /** @var Condition $condition */
        foreach ($task->getConditions() as $condition) {
            $charTypeMap[$condition->getCharacteristic()->getId()] = $condition->getType();
        }

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
            $matrixArr[$cell->getCharacteristic()->getId()][$cell->getAlternative()->getId()] = $cell->getValues()->first()->getValue();
        }

        $newMatrixArr = [];
        foreach ($matrixArr as $characteristicId =>  $characteristicValues) {
            $kmax = max($characteristicValues);
            $kmin = min($characteristicValues);

            foreach ($characteristicValues as $alternativeId => $value) {
                // fixme: пофиксить для нуля
                $type = $charTypeMap[$characteristicId] ?? ConditionType::MIN;
                if ($type === ConditionType::MIN) {
                    $tmpValue = $kmin / $value;
                } else {
                    $tmpValue = $value / $kmax;
                }

                $newMatrixArr[$alternativeId][$characteristicId] = $tmpValue;
            }
        }

        return $newMatrixArr;
    }
}
