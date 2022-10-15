<?php

namespace App\Infrastructure\Symfony\Frontend\Task\Form;

use App\Domain\Core\Entity\Epic;
use App\Domain\Core\Entity\Tag;
use App\Domain\Core\Entity\Task;
use App\Domain\Core\Repository\EpicRepositoryInterface;
use App\Domain\Core\Repository\TagRepositoryInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class TaskType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('uuid')
            ->add('alias', TextType::class, [
                'attr' => [
                    'class' => 'test2'
                ]
            ])
            ->add('creationDate', DateType::class, [
                'widget' => 'single_text'
            ])
            ->add('title', TextType::class, [
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('description', TextareaType::class, [
                'attr' => [
                    'class' => 'richeditor'
                ]
            ])
            ->add('status', ChoiceType::class, [
                'choices' => [
                    'Pending' => 'pending',
                    'In progress' => 'inprogress',
                    'Done' => 'done'
                ]
            ])
            ->add('type', ChoiceType::class, [
                'choices' => [
                    'Task' => 'task',
                    'Bug' => 'bug'
                ]
            ])
            ->add('epic', EntityType::class, [
                'class' => Epic::class,
                'query_builder' => function (EpicRepositoryInterface $er) {
                    return $er->createQueryBuilder('e')
                        ->orderBy('e.title', 'ASC')
                    ;
                },
            ])
            ->add('release')
            ->add('creationUser')
            ->add('currentUser')
            ->add('taskTag', EntityType::class, [
                'class' => Tag::class,
                'multiple' => true,
                'expanded' => true,
                'query_builder' => function (TagRepositoryInterface $er) {
                    return $er->createQueryBuilder('t')
                        ->orderBy('t.name', 'ASC')
                    ;
                },
            ]) 
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
