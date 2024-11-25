<?php

namespace Todo\Domain\Validation;

use Shared\Domain\Validation\AbstractDomainModelValidator;
use Shared\Domain\Validation\Result;
use Todo\Domain\Configuration\TodoListItemConfiguration;

class TodoListItemValidator extends AbstractDomainModelValidator
{
    public function validate(array $data): Result
    {
        $errors = [];

        $this->validateDescription($data, $errors);
        $this->validateCompleted($data, $errors);

        return new Result($errors);
    }

    /**
     * @param array<string, mixed> $data
     * @param array<string, string> $errors
     */
    private function validateDescription(array $data, array &$errors): void
    {
        if (!isset($data['description'])) {
            $errors['description'] = 'listItem.description.required';
        }

        if (!\is_string($data['description'])) {
            $errors['description'] = 'listItem.description.type';
        }

        if (\strlen($data['description']) < TodoListItemConfiguration::getMinDescriptionLength()) {
            $errors['description'] = 'listItem.description.length.minimum';
        }

        if (\strlen($data['description']) > TodoListItemConfiguration::getMaxDescriptionLength()) {
            $errors['description'] = 'listItem.description.length.maximum';
        }
    }

    /**
     * @param array<string, mixed> $data
     * @param array<string, string> $errors
     */
    private function validateCompleted(array $data, array &$errors): void
    {
        if (!isset($data['completed'])) {
            $errors['completed'] = 'listItem.completed.required';
        }

        if (!\is_bool($data['completed'])) {
            $errors['completed'] = 'listItem.completed.type';
        }
    }
}
