<?php

namespace App\Form;

use App\Entity\Epic;
use App\Entity\Task;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TaskType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('uuid')
            ->add('alias')
            ->add('creationDate')
            ->add('title')
            ->add('description')
            ->add('status')
            ->add('type')
            ->add('epic', EntityType::class, [
                'class' => Epic::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('e')
                        ->orderBy('e.title', 'ASC')
                    ;
                },
            ])
            ->add('release')
            ->add('creationUser')
            ->add('currentUser')
            ->add('taskTag') 
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Task::class,
            'project' => null
        ]);
    }
}
