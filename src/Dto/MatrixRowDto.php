<?php

namespace App\Dto;

use App\Entity\Alternative;
use App\Entity\MatrixCell;

class MatrixRowDto
{
    private AlternativeDto $alternative;
    /** @var MatrixCellDto[] */
    private array $cells;

    public function __construct(Alternative $alternative, array $cells)
    {
        $this->cells = array_map(fn (MatrixCell $cell) => new MatrixCellDto($cell), $cells);

        $this->alternative = new AlternativeDto($alternative);
    }

    public function toArray(): array
    {
        return [
            'alternative' => $this->alternative->toArray(),
            'cells' => array_map(fn (MatrixCellDto $cell) => $cell->toArray(), $this->cells),
        ];
    }
}
