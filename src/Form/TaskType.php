<?php

namespace App\Form;

use App\Entity\Epic;
use App\Entity\Tag;
use App\Entity\Task;
use App\Repository\TagRepository;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\LessThanOrEqual;
use Symfony\Component\Validator\Constraints\NotBlank;

class TaskType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('uuid', TextType::class, [
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('alias')
            ->add('creationDate', DateType::class, [
                'widget' => 'single_text',
                'constraints' => [
                    new NotBlank(),
                    new LessThanOrEqual('today')
                ]
            ])
            ->add('title', TextType::class, [
                'constraints' => [
                    new NotBlank(),
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
                    'In Progress' => 'inprogress',
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
                'query_builder' => function (EntityRepository $er) {
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
                'expanded' => true,
                'multiple' => true,
                'query_builder' => function (TagRepository $er) {
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
