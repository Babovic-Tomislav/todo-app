<?php

namespace Todo\Domain\Validation;

use Shared\Domain\Validation\AbstractDomainModelValidator;
use Shared\Domain\Validation\Result;
use Todo\Domain\Configuration\TodoListConfiguration;
use User\Domain\Specification\UserWithEmailExistsSpecification;

final class TodoListValidator extends AbstractDomainModelValidator
{
    public function __construct(
        private readonly UserWithEmailExistsSpecification $userWithEmailExistsSpecification,
        private readonly TodoListItemValidator $listItemValidator,
    ) {
    }

    public function validate(array $data): Result
    {
        $errors = [];

        $this->validateName($data, $errors);
        $this->validateDescription($data, $errors);
        $this->validateItems($data, $errors);
        $this->validateUser($data, $errors);

        return new Result($errors);
    }

    /**
     * @param array<string, mixed> $data
     * @param array<string, string> $errors
     */
    private function validateName(array $data, array &$errors): void
    {
        if (!isset($data['name'])) {
            $errors['name'] = 'list.name.required';
        }

        if (!\is_string($data['name'])) {
            $errors['name'] = 'list.name.type';
        }

        if (\strlen($data['name']) < TodoListConfiguration::minimumNameLength()) {
            $errors['name'] = 'list.name.length.minimum';
        }

        if (\strlen($data['name']) > TodoListConfiguration::maximumNameLength()) {
            $errors['name'] = 'list.name.length.maximum';
        }
    }

    /**
     * @param array<string, mixed> $data
     * @param array<string, string> $errors
     */
    private function validateDescription(array $data, array &$errors): void
    {
        if (!isset($data['description'])) {
            $errors['description'] = 'list.description.required';
        }

        if (!\is_string($data['description'])) {
            $errors['description'] = 'list.description.type';
        }

        if (\strlen($data['description']) < TodoListConfiguration::minimumDescriptionLength()) {
            $errors['description'] = 'list.description.length.minimum';
        }

        if (\strlen($data['description']) > TodoListConfiguration::maximumDescriptionLength()) {
            $errors['description'] = 'list.description.length.maximum';
        }
    }

    /**
     * @param array<string, mixed> $data
     * @param array<string, string> $errors
     */
    private function validateItems(array $data, array &$errors): void
    {
        if (!isset($data['items'])) {
            $errors['items'] = 'list.items.required';
        }

        if (!\is_array($data['items'])) {
            $errors['items'] = 'list.items.type';
        }

        foreach ($data['items'] as $item) {
            $result = $this->listItemValidator->validate($item);

            if ($result->isValid() === false) {
                $errors['items'] = 'list.items.invalid';
            }
        }
    }

    /**
     * @param array<string, mixed> $data
     * @param array<string, string> $errors
     */
    private function validateUser(array $data, array &$errors): void
    {
        if (!isset($data['user'])) {
            $errors['user'] = 'list.user.required';
        }

        if (!\is_string($data['user'])) {
            $errors['user'] = 'list.user.type';
        }

        if (!$this->userWithEmailExistsSpecification->isSatisfiedBy($data['user'])) {
            $errors['user'] = 'list.user.not_found';
        }
    }
}
