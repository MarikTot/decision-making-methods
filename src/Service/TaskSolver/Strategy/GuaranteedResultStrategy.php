<?php

namespace App\Service\TaskSolver\Strategy;

use App\Entity\Cell;
use App\Entity\Condition;
use App\Entity\Task;
use App\Enum\ConditionType;
use App\Enum\DecisionMakingMethod;

class GuaranteedResultStrategy implements SolverStrategyInterface
{
    private array $alternativeMap = [];
    private array $characteristicMap = [];
    private array $charTypeMap = [];

    public static function getName(): string
    {
        return DecisionMakingMethod::GUARANTEED_RESULT;
    }

    public function solve(Task $task): array
    {
        foreach ($task->getAlternatives() as $alternative) {
            $this->alternativeMap[$alternative->getId()] = $alternative;
        }
        foreach ($task->getCharacteristics() as $characteristic) {
            $this->characteristicMap[$characteristic->getId()] = $characteristic;
        }

        /** @var Condition $condition */
        foreach ($task->getConditions() as $condition) {
            $this->charTypeMap[$condition->getCharacteristic()->getId()] = $condition->getType();
        }

        $matrixArr = $this->normalize($task);

        /**
         * 3. находим худшее значение по каждой
         * 4. располагам по убыванию
         */

        $result = [];
        foreach ($matrixArr as $alternativeId => $data) {
            $normalizeData = [];
            foreach ($data as $characteristicId => $value) {
                $normalizeData[$this->characteristicMap[$characteristicId]->getName()] = $value;
            }
            $result[] = [
                'alternativeId' => $alternativeId,
                'name' => $this->alternativeMap[$alternativeId]->getName(),
                'value' => min($data),
                'normalizeData' => $normalizeData,
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
                $type = $this->charTypeMap[$characteristicId] ?? ConditionType::MIN;
                if ($type === ConditionType::MIN) {
                    $tmpValue = $kmin === $value ? 1 : $kmin / $value;
                } else {
                    $tmpValue = $kmax === $value ? 1 : $value / $kmax;
                }

                $newMatrixArr[$alternativeId][$characteristicId] = $tmpValue;
            }
        }

        return $newMatrixArr;
    }
}
