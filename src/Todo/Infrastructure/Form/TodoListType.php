<?php

namespace Todo\Infrastructure\Form;

use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Todo\Domain\Configuration\TodoListConfiguration;

class TodoListType extends AbstractType
{
    public function __construct(
        private Security $security,
    ) {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('id', HiddenType::class)
            ->add('name', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Length(['min' => TodoListConfiguration::minimumNameLength(), 'max' => TodoListConfiguration::maximumNameLength()]),
                ],
            ])
            ->add('description', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Length(['min' => TodoListConfiguration::minimumDescriptionLength(), 'max' => TodoListConfiguration::maximumDescriptionLength()]),
                ],
            ])
            ->add('items', CollectionType::class, [
                'entry_type' => TodoListItemFormType::class,
                'allow_delete' => true,                 // Allow deleting items
                'allow_add' => true,                    // Allow adding new items
                'by_reference' => false,                // Prevent the direct association with the object
                'prototype' => true,                    // Enable the prototype, which allows dynamic adding
                'prototype_name' => '__name__',         // Placeholder for dynamic element name
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('user', HiddenType::class, [
                'empty_data' => $this->security->getUser()?->getUserIdentifier(),
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('save', SubmitType::class)
        ;
    }
}
