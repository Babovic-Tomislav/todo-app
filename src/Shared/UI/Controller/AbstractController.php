<?php

namespace Shared\UI\Controller;

use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

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

    /**
     * @return array<string, mixed>
     *
     * @throws \JsonException
     */
    protected function extractJSONPayload(Request $request): array
    {
        $content = $request->getContent();
        if (\is_resource($content)) {
            throw new BadRequestHttpException('Unexpected request contents received');
        }

        return json_decode((string) $request->getContent(), true, 512, \JSON_THROW_ON_ERROR);
    }
}
