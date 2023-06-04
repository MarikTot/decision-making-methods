<?php

namespace App\Dto;

use App\Entity\Alternative;
use App\Entity\Cell;

class AlternativeCellsDto
{
    public function __construct(
        private Alternative $alternative,
        /** @var Cell[] */
        private array $cells,
    ) {
    }

    public function getAlternative(): Alternative
    {
        return $this->alternative;
    }

    /**
     * @return Cell[]
     */
    public function getCells(): array
    {
        return $this->cells;
    }
}
