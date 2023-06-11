<?php

namespace App\Service\TaskSolver;

use App\Entity\Result;
use App\Repository\TaskRepository;
use App\Service\Matrix\MatrixService;
use App\Service\TaskSolver\Factory\SolverStrategyFactory;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;

class TaskSolverService
{
    public function __construct(
        private TaskRepository $tasks,
        private MatrixService $matrixService,
        private SolverStrategyFactory $solverStrategyFactory,
        private Security $security,
        private EntityManagerInterface $em,
    ) {
    }

    public function solve(int $taskId, string $method): Result
    {
        /**
         * 1. Находим таску
         */
        $task = $this->tasks->findOrThrow($taskId);

        /**
         * 2. "нормализуем матрицу" на основе макс мин
         * 3. находим худшее значение по каждой
         * 4. располагам по убыванию
         */
        $strategy = $this->solverStrategyFactory->create($method);
        $resultData = $strategy->solve($task);

        /**
         * 5. сохраняем
         */
        $result = new Result();

        $result->setTask($task);
        $result->setResult($resultData);
        $result->setCreatedAt(new DateTimeImmutable());
        $result->setMethod($method);
        $result->setCreatedBy($this->security->getUser());

        $this->em->persist($result);
        $this->em->flush();

        return $result;
    }
}
