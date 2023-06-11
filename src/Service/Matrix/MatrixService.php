<?php

namespace App\Service\Matrix;

use App\Dto\MatrixDataDto;
use App\Entity\Alternative;
use App\Entity\Characteristic;
use App\Entity\Matrix;
use App\Entity\MatrixAlternative;
use App\Entity\Cell;
use App\Entity\Value;
use App\Entity\MatrixCharacteristic;
use App\Repository\CellRepository;
use App\Repository\MatrixRepository;
use App\Service\Matrix\Exception\AlternativeAlreadyExistsException;
use App\Service\Matrix\Exception\CharacteristicAlreadyExistsException;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class MatrixService
{
    public function __construct(
        private MatrixRepository $matrices,
        private CellRepository $cells,
        private EntityManagerInterface $em,
    ) {
    }

    public function save(Matrix $matrix, MatrixDataDto $dto): void
    {
        $matrix->setTitle($dto->getTitle());

        $addAlternatives = array_diff($dto->getAlternatives(), $matrix->getAlternatives()->toArray());
        $removeAlternatives = array_diff($matrix->getAlternatives()->toArray(), $dto->getAlternatives());

        $addCharacteristics = array_diff($dto->getCharacteristics(), $matrix->getCharacteristics()->toArray());
        $removeCharacteristics = array_diff($matrix->getCharacteristics()->toArray(), $dto->getCharacteristics());


        foreach ($addAlternatives as $alternative) {
            $this->addAlternative($matrix, $alternative);
        }

        foreach ($removeAlternatives as $alternative) {
            $this->removeAlternative($matrix, $alternative);
        }

        foreach ($addCharacteristics as $characteristic) {
            $this->addCharacteristic($matrix, $characteristic);
        }

        foreach ($removeCharacteristics as $characteristic) {
            $this->removeCharacteristic($matrix, $characteristic);
        }

        $this->em->persist($matrix);
        $this->em->flush();
    }

    private function addAlternative(Matrix $matrix, Alternative $alternative): void
    {
        if ($matrix->getAlternatives()->contains($alternative)) {
            throw new AlternativeAlreadyExistsException();
        }

        $matrixAlternative = new MatrixAlternative();

        $matrixAlternative->setMatrix($matrix);
        $matrixAlternative->setAlternative($alternative);

        $this->em->persist($matrixAlternative);

        $matrix->addMatrixAlternative($matrixAlternative);

        foreach ($matrix->getCharacteristics() as $characteristic) {
            $this->createCell($matrix, $alternative, $characteristic);
        }
    }

    private function addCharacteristic(Matrix $matrix, Characteristic $characteristic): void
    {
        if ($matrix->getCharacteristics()->contains($characteristic)) {
            throw new CharacteristicAlreadyExistsException();
        }

        $matrixCharacteristic = new MatrixCharacteristic();

        $matrixCharacteristic->setMatrix($matrix);
        $matrixCharacteristic->setCharacteristic($characteristic);
        $matrixCharacteristic->setCreatedAt(new DateTimeImmutable());

        $this->em->persist($matrixCharacteristic);

        $matrix->addMatrixCharacteristic($matrixCharacteristic);

        foreach ($matrix->getAlternatives() as $alternative) {
            $this->createCell($matrix, $alternative, $characteristic);
        }
    }

    private function removeAlternative(Matrix $matrix, Alternative $alternative): void
    {
        /** @var MatrixAlternative $ma */
        foreach ($matrix->getMatrixAlternative() as $ma) {
            if ($alternative->getId() === $ma->getAlternative()->getId()) {
                $matrix->removeMatrixAlternative($ma);
                $this->em->remove($ma);
                break;
            }
        }

        $cells = $this->cells->findBy([
            'matrixId' => $matrix->getId(),
            'alternativeId' => $alternative->getId(),
        ]);

        foreach ($cells as $cell) {
            /** @var Value $value */
            foreach ($cell->getValues() as $value) {
                $this->em->remove($value);
            }
            $this->em->remove($cell);
        }
    }

    private function removeCharacteristic(Matrix $matrix, Characteristic $characteristic): void
    {

        /** @var MatrixCharacteristic $mc */
        foreach ($matrix->getMatrixCharacteristic() as $mc) {
            if ($characteristic->getId() === $mc->getCharacteristic()->getId()) {
                $matrix->removeMatrixCharacteristic($mc);
                $this->em->remove($mc);
                break;
            }
        }

        $cells = $this->cells->findBy([
            'matrixId' => $matrix->getId(),
            'characteristicId' => $characteristic->getId(),
        ]);

        foreach ($cells as $cell) {
            /** @var Value $value */
            foreach ($cell->getValues() as $value) {
                $this->em->remove($value);
            }
            $this->em->remove($cell);
        }
    }

    private function createCell(
        Matrix $matrix,
        Alternative $alternative,
        Characteristic $characteristic,
    ): Cell {
        $cell = new Cell();

        $cell->setMatrix($matrix);
        $cell->setAlternative($alternative);
        $cell->setCharacteristic($characteristic);

        $this->em->persist($cell);

        $matrix->addCell($cell);

        return $cell;
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

        foreach ($cell->getValues() as $valueObj) {
            $this->em->remove($valueObj);
        }

        if ($cell->getCharacteristic()->isMultiple()) {
            $value = preg_replace('/\s*,\s*/', ',', $value);

            foreach (explode(',' , $value) as $v) {
                $newValue = new Value();

                $newValue->setValue($v);
                $newValue->setCell($cell);

                $this->em->persist($newValue);
            }
        } else {
            $newValue = new Value();

            $newValue->setValue($value);
            $newValue->setCell($cell);

            $this->em->persist($newValue);
        }

        $this->em->flush();
    }
}
