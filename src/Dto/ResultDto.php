<?php

namespace App\Dto;

use App\Entity\Result;

class ResultDto
{
    private int $id;
    private array $result;
    private string $createdAt;
    private string $createdBy;
    private MethodDto $method;

    public function __construct(Result $decision)
    {
        $this->id = $decision->getId();
        $this->result = $decision->getResult();
        $this->createdAt = $decision->getCreatedAt()->format('H:i d.m.Y');
        $this->createdBy = $decision->getCreatedBy()->getUsername();
        $this->method = new MethodDto($decision->getMethod());
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'result' => $this->result,
            'createdAt' => $this->createdAt,
            'createdBy' => $this->createdBy,
            'method' => $this->method->toArray(),
        ];
    }
}
