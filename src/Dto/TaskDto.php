<?php

namespace App\Dto;

use App\Entity\Task;

class TaskDto
{
    private int $id;
    private string $title;
    private string $description;
    private MatrixDto $matrix;
    private MatrixDto $originalMatrix;
    /** @var ConditionDto[] */
    private array $conditions = [];
    /** @var ResultDto[] */
    private array $results = [];

    public function __construct(Task $task)
    {
        $this->id = (int) $task->getId();
        $this->title = (string) $task->getTitle();
        $this->description = (string) $task->getDescription();

        $this->matrix = new MatrixDto($task->getMatrix(), $task);

        $this->originalMatrix = new MatrixDto($task->getMatrix());

        foreach ($task->getConditions() as $condition) {
            $this->conditions[] = new ConditionDto($condition);
        }

        foreach ($task->getResults() as $result) {
            $this->results[] = new ResultDto($result);
        }
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'matrix' => $this->matrix->toArray(),
            'originalMatrix' => $this->originalMatrix->toArray(),
            'conditions' => array_map(fn(ConditionDto $condition) => $condition->toArray(), $this->conditions),
            'results' => array_map(fn(ResultDto $result) => $result->toArray(), $this->results),
        ];
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getMatrix(): MatrixDto
    {
        return $this->matrix;
    }

    public function getOriginalMatrix(): MatrixDto
    {
        return $this->originalMatrix;
    }

    /**
     * @return ConditionDto[]
     */
    public function getConditions(): array
    {
        return $this->conditions;
    }

    /**
     * @return ResultDto[]
     */
    public function getResults(): array
    {
        return $this->results;
    }
}
