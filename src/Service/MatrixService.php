<?php

namespace App\Service;

use App\Dto\AlternativeCellsDto;
use App\Dto\CharacteristicCellsDto;
use App\Entity\Alternative;
use App\Entity\Characteristic;
use App\Entity\Matrix;
use App\Entity\MatrixCell;
use App\Entity\MatrixCellValue;
use App\Entity\MatrixCondition;
use App\Entity\Task;
use App\Repository\AlternativeRepository;
use App\Repository\CharacteristicRepository;
use App\Repository\MatrixCellRepository;
use App\Repository\MatrixCellValueRepository;
use App\Repository\MatrixRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class MatrixService
{
    public function __construct(
        private MatrixRepository $matrices,
        private AlternativeRepository $alternatives,
        private CharacteristicRepository $characteristics,
        private MatrixCellRepository $cells,
        private MatrixCellValueRepository $values,
        private EntityManagerInterface $em,
    ) {
    }

    public function create(Task $task)
    {
        $matrix = new Matrix();

        $matrix->setTask($task);

        $this->matrices->save($matrix, true);

        return $matrix;
    }

    public function addAlternative(int $id, int $alternativeId): AlternativeCellsDto
    {
        $matrix = $this->findOrThrowMatrix($id);

        $alternative = $this->alternatives->find($alternativeId);

        if (null === $alternative) {
            throw new BadRequestException('Не удалось найти альтернативу');
        }

        $matrix->addAlternative($alternative);

        $cells = [];
        foreach ($matrix->getCharacteristics() as $characteristic) {
            $matrixCell = $this->createCell($matrix, $alternative, $characteristic);
            $cells[] = $matrixCell;
        }
// todo: check cells
        $this->em->flush();

        return new AlternativeCellsDto($alternative, $cells);
    }

    public function addCharacteristic(int $id, int $characteristicId): CharacteristicCellsDto
    {
        $matrix = $this->findOrThrowMatrix($id);

        $characteristic = $this->characteristics->find($characteristicId);

        if (null === $characteristic) {
            throw new BadRequestException('Не удалось найти показатель');
        }

        $matrix->addCharacteristic($characteristic);

        $cells = [];
        foreach ($matrix->getAlternatives() as $alternative) {
            $matrixCell = $this->createCell($matrix, $alternative, $characteristic);
            $cells[] = $matrixCell;
        }
// todo: check cells
        $this->em->flush();

        return new CharacteristicCellsDto($characteristic, $cells);
    }

    private function createCell(
        Matrix $matrix,
        Alternative $alternative,
        Characteristic $characteristic,
    ): MatrixCell {
        $matrixCell = new MatrixCell();

        $matrixCell->setMatrix($matrix);
        $matrixCell->setAlternative($alternative);
        $matrixCell->setCharacteristic($characteristic);

        $this->em->persist($matrixCell);

        $matrix->addMatrixCell($matrixCell);

        return $matrixCell;
    }

    private function findOrThrowMatrix($id): Matrix
    {
        $matrix = $this->matrices->find($id);

        if (null === $matrix) {
            throw new BadRequestException('Не удалось найти матрицу');
        }

        return $matrix;
    }

    public function saveValue(int $cellId, string $value): void
    {
        $cell = $this->cells->find($cellId);

        if (null === $cell) {
            throw new BadRequestException('Не удалось найти ячейку');
        }

        foreach ($cell->getMatrixCellValues() as $cellValue) {
            $this->em->remove($cellValue);
        }

        if ($cell->getCharacteristic()->isMultiple()) {
            $value = preg_replace('/\s*,\s*/', ',', $value);

            foreach (explode(',' , $value) as $v) {
                $newValue = new MatrixCellValue();

                $newValue->setValue($v);
                $newValue->setMatrixCell($cell);

                $this->em->persist($newValue);
            }
        } else {
            $newValue = new MatrixCellValue();

            $newValue->setValue($value);
            $newValue->setMatrixCell($cell);

            $this->em->persist($newValue);
        }

        $this->em->flush();
    }

    public function removeAlternative(int $id, int $alternativeId): void
    {
        $matrix = $this->findOrThrowMatrix($id);

        /** @var Alternative $alternative */
        foreach ($matrix->getAlternatives() as $alternative) {
            if ($alternativeId === $alternative->getId()) {
                $matrix->removeAlternative($alternative);
                break;
            }
        }

        $cells = $this->cells->findBy([
            'matrixId' => $matrix->getId(),
            'alternativeId' => $alternativeId,
        ]);

        foreach ($cells as $cell) {
            /** @var MatrixCellValue $value */
            foreach ($cell->getMatrixCellValues() as $value) {
                $this->em->remove($value);
            }
            $this->em->remove($cell);
        }

        $this->em->flush();
    }

    public function removeCharacteristic(int $id, int $characteristicId): void
    {
        $matrix = $this->findOrThrowMatrix($id);

        /** @var Characteristic $characteristic */
        foreach ($matrix->getCharacteristics() as $characteristic) {
            if ($characteristicId === $characteristic->getId()) {
                $matrix->removeCharacteristic($characteristic);
                break;
            }
        }

        $cells = $this->cells->findBy([
            'matrixId' => $matrix->getId(),
            'characteristicId' => $characteristicId,
        ]);

        foreach ($cells as $cell) {
            /** @var MatrixCellValue $value */
            foreach ($cell->getMatrixCellValues() as $value) {
                $this->em->remove($value);
            }
            $this->em->remove($cell);
        }

        $this->em->flush();
    }

    public function saveCondition(
        int $id,
        int $characteristicId,
        string $condition,
    ): MatrixCondition {
        // todo: add condition validation

        $matrix = $this->findOrThrowMatrix($id);

        $characteristic = $this->characteristics->find($characteristicId);

        if (null === $characteristic) {
            throw new BadRequestException('Не удалось найти показатель');
        }

        /** @var null|MatrixCondition $currentCondition */
        $matrixCondition = $matrix->getMatrixConditions()
            ->reduce(fn (?MatrixCondition $result, MatrixCondition $mc) => $mc->getCharacteristic()->getId() === $characteristicId ? $mc : $result);

        if (null === $matrixCondition) {
            $matrixCondition = new MatrixCondition();

            $matrixCondition->setMatrix($matrix);
            $matrixCondition->setCharacteristic($characteristic);
        }

        $matrixCondition->setType($condition);

        $this->em->persist($matrixCondition);
        $this->em->flush();

        return $matrixCondition;
    }
}
