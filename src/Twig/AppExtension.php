<?php

namespace App\Twig;

use App\Enum\DecisionMakingMethod;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('methodLabel', [DecisionMakingMethod::class, 'getLabel']),
        ];
    }
}
