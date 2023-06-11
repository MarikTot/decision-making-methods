<?php

namespace App\Service\TaskSolver\Factory;

use App\Service\TaskSolver\Strategy\GuaranteedResultStrategy;
use App\Service\TaskSolver\Strategy\SolverStrategyInterface;

class SolverStrategyFactory
{
    public function __construct(
        private GuaranteedResultStrategy $paretoStrategy,
    ) {
    }

    public function create(string $method): SolverStrategyInterface
    {
        return match ($method) {
            GuaranteedResultStrategy::getName() => $this->paretoStrategy,
            default => throw new \Exception('Method not found'),
        };
    }
}
