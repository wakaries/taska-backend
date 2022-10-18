<?php

namespace App\Infrastructure\Symfony\Frontend\Form;

use App\Application\Task\PersistTaskInput;
use App\Application\Task\TaskObject;
use App\Domain\Core\Entity\Task;
use App\Infrastructure\Symfony\Frontend\Form\Type\EpicChoiceType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TaskType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('alias', TextType::class, [
                'attr' => [
                    'class' => 'test2'
                ]
            ])
            ->add('creationDate', DateType::class, [
                'widget' => 'single_text'
            ])
            ->add('title', TextType::class, [
            ])
            ->add('description', TextareaType::class, [
                'attr' => [
                    'class' => 'richeditor'
                ]
            ])
            ->add('type', ChoiceType::class, [
                'choices' => Task::getTypes()
            ])
            ->add('epic', EpicChoiceType::class)
            ->add('creationUser')
            ->add('currentUser')
            /*
            ->add('taskTag', EntityType::class, [
                'class' => Tag::class,
                'multiple' => true,
                'expanded' => true,
                'query_builder' => function (TagRepository $er) {
                    return $er->createQueryBuilder('t')
                        ->orderBy('t.name', 'ASC')
                    ;
                },
            ])
            */
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TaskObject::class
        ]);
    }
}
