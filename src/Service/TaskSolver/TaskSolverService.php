<?php

namespace App\Service\TaskSolver;

use App\Entity\Result;
use App\Entity\User;
use App\Repository\TaskRepository;
use App\Service\TaskSolver\Factory\SolverStrategyFactory;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;

class TaskSolverService
{
    public function __construct(
        private TaskRepository $tasks,
        private SolverStrategyFactory $solverStrategyFactory,
        private Security $security,
        private EntityManagerInterface $em,
    ) {
    }

    public function solve(int $taskId, string $method): Result
    {
        $task = $this->tasks->findOrThrow($taskId);

        $strategy = $this->solverStrategyFactory->create($method);
        $resultData = $strategy->solve($task);

        /** @var User $user */
        $user = $this->security->getUser();

        $result = new Result();

        $result->setTask($task);
        $result->setResult($resultData);
        $result->setCreatedAt(new DateTimeImmutable());
        $result->setMethod($method);
        $result->setCreatedBy($user);

        $this->em->persist($result);
        $this->em->flush();

        return $result;
    }
}
