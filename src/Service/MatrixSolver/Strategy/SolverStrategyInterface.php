<?php

namespace App\Service\MatrixSolver\Strategy;

use App\Entity\Matrix;

interface SolverStrategyInterface
{
    public static function getName(): string;

    public function solve(Matrix $matrix): array;
}
