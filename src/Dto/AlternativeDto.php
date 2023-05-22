<?php

namespace App\Dto;

use App\Entity\Alternative;

class AlternativeDto
{
    private int $id;
    private string $name;

    public function __construct(Alternative $alternative)
    {
        $this->id = $alternative->getId();
        $this->name = $alternative->getName();
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }
}
