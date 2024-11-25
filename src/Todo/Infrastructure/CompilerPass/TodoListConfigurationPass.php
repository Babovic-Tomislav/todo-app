<?php

namespace Todo\Infrastructure\CompilerPass;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Todo\Domain\Configuration\TodoListConfiguration;

class TodoListConfigurationPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        $minimumNameLength = $container->hasParameter('app.minimum_name_length')
            ? $container->getParameter('app.minimum_name_length')
            : TodoListConfiguration::DEFAULT_NAME_MINIMUM_LENGTH;

        if (\is_int($minimumNameLength)) {
            TodoListConfiguration::setMinimumNameLength($minimumNameLength);
        }

        $maximumNameLength = $container->hasParameter('app.maximum_name_length')
            ? $container->getParameter('app.maximum_name_length')
            : TodoListConfiguration::DEFAULT_NAME_MAXIMUM_LENGTH;

        if (\is_int($maximumNameLength)) {
            TodoListConfiguration::setMaximumNameLength($maximumNameLength);
        }

        $minimumDescriptionLength = $container->hasParameter('app.minimum_description_length')
            ? $container->getParameter('app.minimum_description_length')
            : TodoListConfiguration::DEFAULT_DESCRIPTION_MINIMUM_LENGTH;

        if (\is_int($minimumDescriptionLength)) {
            TodoListConfiguration::setMinimumDescriptionLength($minimumDescriptionLength);
        }

        $maximumDescriptionLength = $container->hasParameter('app.maximum_description_length')
            ? $container->getParameter('app.maximum_description_length')
            : TodoListConfiguration::DEFAULT_DESCRIPTION_MAXIMUM_LENGTH;

        if (\is_int($maximumDescriptionLength)) {
            TodoListConfiguration::setMaximumDescriptionLength($maximumDescriptionLength);
        }
    }
}
