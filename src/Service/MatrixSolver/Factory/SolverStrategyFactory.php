<?php

namespace App\Service\MatrixSolver\Factory;

use App\Service\MatrixSolver\Strategy\GuaranteedResultStrategy;
use App\Service\MatrixSolver\Strategy\SolverStrategyInterface;

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
