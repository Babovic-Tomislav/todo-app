<?php

namespace User\Infrastructure\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use User\Domain\Configuration\UserConfiguration;

class RegisterUserFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Length([
                        'min' => UserConfiguration::getMinimumNameLength(),
                        'max' => UserConfiguration::getMaximumNameLength(),
                    ]),
                ],
            ])
            ->add('lastname', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Length([
                        'min' => UserConfiguration::getMinimumLastnameLength(),
                        'max' => UserConfiguration::getMaximumLastnameLength(),
                    ]),
                ],
            ])
            ->add('username', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Length([
                        'min' => UserConfiguration::getMinimumUsernameLength(),
                        'max' => UserConfiguration::getMaximumUsernameLength(),
                    ]),
                ],
            ])
            ->add('email', EmailType::class)
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'The password fields must match.',
                'options' => ['attr' => ['class' => 'password-field']],
                'required' => true,
                'first_options' => ['label' => 'Password'],
                'second_options' => ['label' => 'Repeat Password'],
                'constraints' => [
                    new NotBlank(),
                    new Length([
                        //                        'min' => UserConfiguration::getMinimumPasswordLength(),
                        'max' => UserConfiguration::getMaximumPasswordLength(),
                    ]),
                ],
            ])
            ->add('active', HiddenType::class, [
                'empty_data' => false,
            ])
            ->add('save', SubmitType::class)
        ;
    }
}
