<?php

namespace App\Infrastructure\Symfony\Frontend\Form\Type;

use App\Application\Epic\ListEpicsQuery;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EpicChoiceType extends AbstractType
{
    public function __construct(private ListEpicsQuery $listEpicsQuery) {}

    public function configureOptions(OptionsResolver $resolver): void
    {
        $epics = $this->listEpicsQuery->execute();
        $choices = [];
        foreach ($epics as $epic) {
            $choices[$epic->getTitle()] = $epic->getUuid();
        }
        $resolver->setDefaults([
            'choices' => $choices,
        ]);
    }

    public function getParent(): string
    {
        return ChoiceType::class;
    }
}