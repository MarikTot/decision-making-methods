<?php

namespace App\Dto;

use App\Entity\Alternative;
use App\Entity\Cell;

class MatrixRowDto
{
    private AlternativeDto $alternative;
    /** @var CellDto[] */
    private array $cells;

    public function __construct(Alternative $alternative, array $cells)
    {

        $this->cells = array_map(fn (Cell $cell) => new CellDto($cell), $cells);

        $this->alternative = new AlternativeDto($alternative);
    }

    public function toArray(): array
    {
        return [
            'alternative' => $this->alternative->toArray(),
            'cells' => array_map(fn (CellDto $cell) => $cell->toArray(), $this->cells),
        ];
    }
}
