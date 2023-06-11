<?php

namespace App\Service\TaskSolver\Factory;

use App\Service\TaskSolver\Strategy\GuaranteedResultStrategy;
use App\Service\TaskSolver\Strategy\ParetoStrategy;
use App\Service\TaskSolver\Strategy\SolverStrategyInterface;

class SolverStrategyFactory
{
    public function __construct(
        private GuaranteedResultStrategy $guaranteedResultStrategy,
        private ParetoStrategy $paretoStrategy,
    ) {
    }

    public function create(string $method): SolverStrategyInterface
    {
        return match ($method) {
            GuaranteedResultStrategy::getName() => $this->guaranteedResultStrategy,
            ParetoStrategy::getName() => $this->paretoStrategy,
            default => throw new \Exception('Method not found'),
        };
    }
}
