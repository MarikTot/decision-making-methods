<?php

namespace App\Dto;

use App\Entity\Alternative;
use App\Entity\MatrixCell;

class AlternativeCellsDto
{
    public function __construct(
        private Alternative $alternative,
        /** @var MatrixCell[] */
        private array $cells,
    ) {
    }

    public function getAlternative(): Alternative
    {
        return $this->alternative;
    }

    /**
     * @return MatrixCell[]
     */
    public function getCells(): array
    {
        return $this->cells;
    }
}
