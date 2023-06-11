<?php

namespace App\Enum;

class DecisionMakingMethod
{
    public const PARETO = 'pareto';
    public const GUARANTEED_RESULT = 'guaranteed_result';

    public static function getLabel(string $name): string
    {
        return match ($name) {
            self::PARETO => 'Метод Парето',
            self::GUARANTEED_RESULT => 'Метод гарантированного результата',
            default => $name,
        };
    }

    public static function getValues(): array
    {
        return [
            self::PARETO,
            self::GUARANTEED_RESULT,
        ];
    }

    public static function getList(): array
    {
        $list = [];
        foreach (self::getValues() as $value) {
            $list[$value] = self::getLabel($value);
        }

        return $list;
    }
}
