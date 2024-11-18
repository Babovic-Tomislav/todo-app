<?php

namespace Shared\UI\Controller;

use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;

abstract class AbstractController
{
    public function __construct(
        private readonly FormFactoryInterface $formFactory,
    ) {
    }

    /**
     * @param array<mixed> $options
     *                              Creates and returns a Form instance from the type of the form
     */
    protected function createForm(string $type, mixed $data = null, array $options = []): FormInterface
    {
        return $this->formFactory->create($type, $data, $options);
    }
}
