<?php

namespace App\Dto;

class TaskDataDto
{
    public function __construct(
        private string $name,
        private int $matrixId,
        private string $description,
        private array $alternativeIds,
        private array $characteristicIds,
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getMatrixId(): string
    {
        return $this->matrixId;
    }

    public function setMatrixId(string $matrixId): void
    {
        $this->matrixId = $matrixId;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getAlternativeIds(): array
    {
        return $this->alternativeIds;
    }

    public function setAlternativeIds(array $alternativeIds): void
    {
        $this->alternativeIds = $alternativeIds;
    }

    public function getCharacteristicIds(): array
    {
        return $this->characteristicIds;
    }

    public function setCharacteristicIds(array $characteristicIds): void
    {
        $this->characteristicIds = $characteristicIds;
    }
}
