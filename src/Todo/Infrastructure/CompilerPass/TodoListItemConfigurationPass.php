<?php

namespace Todo\Infrastructure\CompilerPass;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Todo\Domain\Configuration\TodoListItemConfiguration;

class TodoListItemConfigurationPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        $minimumDescriptionLength = $container->hasParameter('app.minimum_description_length')
            ? $container->getParameter('app.minimum_description_length')
            : TodoListItemConfiguration::MIN_DESCRIPTION_LENGTH;

        if (\is_int($minimumDescriptionLength)) {
            TodoListItemConfiguration::setMinDescriptionLength($minimumDescriptionLength);
        }

        $maximumDescriptionLength = $container->hasParameter('app.maximum_description_length')
            ? $container->getParameter('app.maximum_description_length')
            : TodoListItemConfiguration::MAX_DESCRIPTION_LENGTH;

        if (\is_int($maximumDescriptionLength)) {
            TodoListItemConfiguration::setMaxDescriptionLength($maximumDescriptionLength);
        }
    }
}
