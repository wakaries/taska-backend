<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('userDate', [$this, 'getUserDate'])
        ];
    }

    public function getUserDate(\DateTime $date): string
    {
        return $date->format('d/m/Y');
    }
}
