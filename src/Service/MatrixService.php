<?php

namespace App\Service;

use App\Dto\AlternativeCellsDto;
use App\Dto\CharacteristicCellsDto;
use App\Entity\Alternative;
use App\Entity\Characteristic;
use App\Entity\Matrix;
use App\Entity\MatrixAlternative;
use App\Entity\MatrixCell;
use App\Entity\MatrixCellValue;
use App\Entity\MatrixCharacteristic;
use App\Entity\MatrixCondition;
use App\Entity\Task;
use App\Repository\AlternativeRepository;
use App\Repository\CharacteristicRepository;
use App\Repository\MatrixCellRepository;
use App\Repository\MatrixCellValueRepository;
use App\Repository\MatrixRepository;
use DateTimeImmutable;
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

        $alreadyExist = $matrix->getMatrixAlternative()->reduce(function (bool $accum, MatrixAlternative $ma) use ($alternative) {
            return $accum || $ma->getAlternative()->getId() === $alternative->getId();
        }, false);

        if ($alreadyExist) {
            // todo:
            throw new \Exception();
        }

        $matrixAlternative = new MatrixAlternative();

        $matrixAlternative->setMatrix($matrix);
        $matrixAlternative->setAlternative($alternative);
        $matrixAlternative->setCreatedAt(new DateTimeImmutable());

        $this->em->persist($matrixAlternative);

        $matrix->addMatrixAlternative($matrixAlternative);

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

        $alreadyExist = $matrix->getMatrixCharacteristic()->reduce(function (bool $accum, MatrixCharacteristic $mc) use ($characteristic) {
            return $accum || $mc->getCharacteristic()->getId() === $characteristic->getId();
        }, false);

        if ($alreadyExist) {
            // todo:
            throw new \Exception();
        }

        $matrixCharacteristic = new MatrixCharacteristic();

        $matrixCharacteristic->setMatrix($matrix);
        $matrixCharacteristic->setCharacteristic($characteristic);
        $matrixCharacteristic->setCreatedAt(new DateTimeImmutable());

        $this->em->persist($matrixCharacteristic);

        $matrix->addMatrixCharacteristic($matrixCharacteristic);

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

    public function findOrThrowMatrix($id): Matrix
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

        /** @var MatrixAlternative $ma */
        foreach ($matrix->getMatrixAlternative() as $ma) {
            if ($alternativeId === $ma->getAlternative()->getId()) {
                $matrix->removeMatrixAlternative($ma);
                $this->em->remove($ma);
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

        /** @var MatrixCharacteristic $mc */
        foreach ($matrix->getMatrixCharacteristic() as $mc) {
            if ($characteristicId === $mc->getCharacteristic()->getId()) {
                $matrix->removeMatrixCharacteristic($mc);
                $this->em->remove($mc);
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
