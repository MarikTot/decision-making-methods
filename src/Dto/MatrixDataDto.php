<?php

namespace App\Dto;

use App\Entity\Alternative;
use App\Entity\Characteristic;

class MatrixDataDto
{
    public function __construct(
        private string $title,
        /** @var Alternative[] */
        private array $alternatives,
        /** @var Characteristic[] */
        private array $characteristics,
    ) {
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return Alternative[]
     */
    public function getAlternatives(): array
    {
        return $this->alternatives;
    }

    /**
     * @param Alternative[] $alternatives
     */
    public function setAlternatives(array $alternatives): void
    {
        $this->alternatives = $alternatives;
    }

    /**
     * @return Characteristic[]
     */
    public function getCharacteristics(): array
    {
        return $this->characteristics;
    }

    /**
     * @param Characteristic[] $alternatives
     */
    public function setCharacteristics(array $characteristics): void
    {
        $this->characteristics = $characteristics;
    }
}
