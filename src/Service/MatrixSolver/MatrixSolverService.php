<?php

namespace App\Service\MatrixSolver;

use App\Entity\Result;
use App\Service\Matrix\MatrixService;
use App\Service\MatrixSolver\Factory\SolverStrategyFactory;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;

class MatrixSolverService
{
    public function __construct(
        private MatrixService $matrixService,
        private SolverStrategyFactory $solverStrategyFactory,
        private Security $security,
        private EntityManagerInterface $em,
    ) {
    }

    public function solve(int $matrixId, string $method): Result
    {
        /**
         * 1. Находим матрицу
         */
        $matrix = $this->matrixService->findOrThrowMatrix($matrixId);

        /**
         * 2. "нормализуем ее" на основе макс мин
         * 3. находим худшее значение по каждой
         * 4. располагам по убыванию
         */
        $strategy = $this->solverStrategyFactory->create($method);
        $result = $strategy->solve($matrix);

        /**
         * 5. сохраняем
         */
        $decision = new Result();

//        $decision->setMatrix($matrix);
//        $decision->setResult($result);
//        $decision->setCreatedAt(new DateTimeImmutable());
//        $decision->setMethod($method);
//        $decision->setCreatedBy($this->security->getUser());
//
//        $this->em->persist($decision);
//        $this->em->flush();

        return $decision;
    }
}
