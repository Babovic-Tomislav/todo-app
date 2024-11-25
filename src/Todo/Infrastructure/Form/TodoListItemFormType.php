<?php

namespace Todo\Infrastructure\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Todo\Domain\Configuration\TodoListItemConfiguration;

class TodoListItemFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('id', HiddenType::class)
            ->add('description', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Length(['min' => TodoListItemConfiguration::getMinDescriptionLength(), 'max' => TodoListItemConfiguration::getMaxDescriptionLength()]),
                ],
            ])
            ->add('completed', CheckboxType::class, [
                'required' => false,
            ]);
    }
}
