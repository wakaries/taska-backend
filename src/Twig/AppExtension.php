<?php
namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('appdate', [$this, 'getAppDate'])
        ];
    }

    public function getAppDate(\DateTime $date)
    {
        return $date->format('d/m/Y');
    }
}