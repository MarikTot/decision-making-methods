<?php

namespace App\Service\TaskSolver\Strategy;

use App\Entity\Task;

interface SolverStrategyInterface
{
    public static function getName(): string;

    public function solve(Task $task): array;
}
