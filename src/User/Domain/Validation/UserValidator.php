<?php

namespace User\Domain\Validation;

use Shared\Domain\Validation\AbstractDomainModelValidator;
use Shared\Domain\Validation\Result;
use User\Domain\Configuration\UserConfiguration;
use User\Domain\Specification\IsUniqueEmailSpecificationInterface;

class UserValidator extends AbstractDomainModelValidator
{
    public function __construct(
        private readonly IsUniqueEmailSpecificationInterface $isUniqueEmailSpecification,
    ) {
    }

    public function validate(array $data): Result
    {
        $errors = [];

        $this->validateEmail($data, $errors);
        $this->validateName($data, $errors);
        $this->validateLastname($data, $errors);
        $this->validatePassword($data, $errors);

        return new Result($errors);
    }

    /**
     * @param array<string, mixed> $data
     * @param array<string, string> $errors
     */
    private function validateEmail(array $data, array &$errors): void
    {
        if (!isset($data['email'])) {
            $errors['email'] = 'user.email.required';
        }

        if (!filter_var($data['email'], \FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'user.email.invalid';
        }

        if (!$this->isUniqueEmailSpecification->isSatisfiedBy($data['email'])) {
            $errors['email'] = 'user.email.unique';
        }
    }

    /**
     * @param array<string, mixed> $data
     * @param array<string, string> $errors
     */
    private function validateName(array $data, array &$errors): void
    {
        if (!isset($data['name'])) {
            $errors['name'] = 'user.name.required';
        }

        if (!\is_string($data['name'])) {
            $errors['name'] = 'user.name.type';
        }

        if (\strlen($data['name']) < UserConfiguration::getMinimumNameLength()) {
            $errors['name'] = 'user.name.length.minimum';
        }

        if (\strlen($data['name']) > UserConfiguration::getMaximumNameLength()) {
            $errors['name'] = 'user.name.length.maximum';
        }
    }

    /**
     * @param array<string, mixed> $data
     * @param array<string, string> $errors
     */
    private function validatePassword(array $data, array &$errors): void
    {
        if (!isset($data['password'])) {
            $errors['password'] = 'user.password.required';
        }

        if (!\is_string($data['password'])) {
            $errors['password'] = 'user.password.type';
        }

        if (\strlen($data['password']) < UserConfiguration::getMinimumPasswordLength()) {
            $errors['password'] = 'user.password.length.minimum';
        }

        if (\strlen($data['password']) > UserConfiguration::getMaximumPasswordLength()) {
            $errors['password'] = 'user.password.length.maximum';
        }
    }

    /**
     * @param array<string, mixed> $data
     * @param array<string, string> $errors
     */
    private function validateLastname(array $data, array &$errors): void
    {
        if (!isset($data['lastname'])) {
            $errors['lastname'] = 'user.lastname.required';
        }

        if (!\is_string($data['lastname'])) {
            $errors['lastname'] = 'user.lastname.type';
        }

        if (\strlen($data['lastname']) < UserConfiguration::getMinimumLastnameLength()) {
            $errors['lastname'] = 'user.lastname.length.minimum';
        }

        if (\strlen($data['lastname']) > UserConfiguration::getMaximumLastnameLength()) {
            $errors['lastname'] = 'user.lastname.length.maximum';
        }
    }
}
