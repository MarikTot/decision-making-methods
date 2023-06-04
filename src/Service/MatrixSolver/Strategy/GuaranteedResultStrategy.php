<?php

namespace App\Service\MatrixSolver\Strategy;

use App\Entity\Matrix;
use App\Entity\Cell;
use App\Entity\Condition;
use App\Enum\DecisionMakingMethod;

class GuaranteedResultStrategy implements SolverStrategyInterface
{
    public static function getName(): string
    {
        return DecisionMakingMethod::GUARANTEED_RESULT;
    }

    public function solve(Matrix $matrix): array
    {
        $alternativeMap = [];
        foreach ($matrix->getAlternatives() as $alternative) {
            $alternativeMap[$alternative->getId()] = $alternative;
        }

        $matrixArr = $this->normalize($matrix);
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
    public function normalize(Matrix $matrix): array
    {
        $charTypeMap = [];
        /** @var Condition $condition */
        foreach ($matrix->getConditions() as $condition) {
            $charTypeMap[$condition->getCharacteristic()->getId()] = $condition->getType();
        }

        $matrixArr = [];
        /** @var Cell $cell */
        foreach ($matrix->getCells() as $cell) {
            // todo: переделать на множественное число потом
            $matrixArr[$cell->getCharacteristic()->getId()][$cell->getAlternative()->getId()] = $cell->getValues()->first()->getValue();
        }

        $newMatrixArr = [];
        foreach ($matrixArr as $characteristicId =>  $characteristicValues) {
            $kmax = max($characteristicValues);
            $kmin = min($characteristicValues);

            foreach ($characteristicValues as $alternativeId => $value) {
                $tmpValue = $value / $kmax;

                $type = $charTypeMap[$characteristicId] ?? 'min';
                if ($type === 'min') {
                    $tmpValue = $kmin / $value;
                }

                $newMatrixArr[$alternativeId][$characteristicId] = $tmpValue;
            }
        }

        return $newMatrixArr;
    }
}
