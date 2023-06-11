<?php

namespace App\Dto;

use App\Enum\DecisionMakingMethod;

class MethodDto
{
    private string $value;
    private string $label;

    public function __construct(string $method)
    {
        $this->value = $method;
        $this->label = DecisionMakingMethod::getLabel($method);
    }

    public function toArray(): array
    {
        return [
            'value' => $this->value,
            'label' => $this->label,
        ];
    }
}
