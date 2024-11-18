<?php

namespace User\Domain\Validation;

use Shared\Domain\Translator\TranslatorInterface;
use Shared\Domain\Validation\AbstractDomainModelValidator;
use Shared\Domain\Validation\Result;
use User\Domain\Configuration\UserConfiguration;
use User\Domain\Specification\IsUniqueEmailSpecificationInterface;

class UserValidator extends AbstractDomainModelValidator
{
    public function __construct(
        private IsUniqueEmailSpecificationInterface $isUniqueEmailSpecification,
        protected TranslatorInterface $translator,
    ) {
        parent::__construct($this->translator);
    }

    // validate user, use $errors
    public function validate(array $data): Result
    {
        $errors = [];

        if (!isset($data['name'])) {
            $errors['name'] = $this->translator->translate('Name is required');
        }

        if (!isset($data['lastname'])) {
            $errors['lastname'] = $this->translator->translate('Lastname is required');
        }

        if (!isset($data['username'])) {
            $errors['username'] = $this->translator->translate('Username is required');
        }

        if (!isset($data['email'])) {
            $errors['email'] = $this->translator->translate('Email is required');
        }

        if (!isset($data['password'])) {
            $errors['password'] = $this->translator->translate('Password is required');
        }

        if (!filter_var($data['email'], \FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = $this->translator->translate('Invalid email format');
        }

        if (\strlen($data['password']) < UserConfiguration::getMinimumPasswordLength()) {
            $errors['password'] = $this->translator->translate('password.length.minimum', ['%limit%' => UserConfiguration::getMinimumPasswordLength()]);
        }

        if ($this->isUniqueEmailSpecification->isSatisfiedBy($data['email'])) {
            $errors['email'] = $this->translator->translate('Email is already in use');
        }

        return new Result($errors);
    }
}
