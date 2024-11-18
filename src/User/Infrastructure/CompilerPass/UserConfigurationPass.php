<?php

namespace User\Infrastructure\CompilerPass;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use User\Domain\Configuration\UserConfiguration;

class UserConfigurationPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        $minimumPasswordLength = $container->hasParameter('app.minimum_password_length')
            ? $container->getParameter('app.minimum_password_length')
            : UserConfiguration::DEFAULT_PASSWORD_MINIMUM_LENGTH;

        if (\is_int($minimumPasswordLength)) {
            UserConfiguration::setMinimumPasswordLength($minimumPasswordLength);
        }

        $maximumPasswordLength = $container->hasParameter('app.maximum_password_length')
            ? $container->getParameter('app.maximum_password_length')
            : UserConfiguration::DEFAULT_PASSWORD_MAXIMUM_LENGTH;

        if (\is_int($maximumPasswordLength)) {
            UserConfiguration::setMaximumPasswordLength($maximumPasswordLength);
        }

        $minimumUsernameLength = $container->hasParameter('app.minimum_username_length')
            ? $container->getParameter('app.minimum_username_length')
            : UserConfiguration::DEFAULT_USERNAME_MINIMUM_LENGTH;

        if (\is_int($minimumUsernameLength)) {
            UserConfiguration::setMinimumUsernameLength($minimumUsernameLength);
        }

        $maximumUsernameLength = $container->hasParameter('app.maximum_username_length')
            ? $container->getParameter('app.maximum_username_length')
            : UserConfiguration::DEFAULT_USERNAME_MAXIMUM_LENGTH;

        if (\is_int($maximumUsernameLength)) {
            UserConfiguration::setMaximumUsernameLength($maximumUsernameLength);
        }

        $minimumNameLength = $container->hasParameter('app.minimum_name_length')
            ? $container->getParameter('app.minimum_name_length')
            : UserConfiguration::DEFAULT_NAME_MINIMUM_LENGTH;

        if (\is_int($minimumNameLength)) {
            UserConfiguration::setMinimumNameLength($minimumNameLength);
        }

        $maximumNameLength = $container->hasParameter('app.maximum_name_length')
            ? $container->getParameter('app.maximum_name_length')
            : UserConfiguration::DEFAULT_NAME_MAXIMUM_LENGTH;

        if (\is_int($maximumNameLength)) {
            UserConfiguration::setMaximumNameLength($maximumNameLength);
        }

        $minimumLastnameLength = $container->hasParameter('app.minimum_lastname_length')
            ? $container->getParameter('app.minimum_lastname_length')
            : UserConfiguration::DEFAULT_LASTNAME_MINIMUM_LENGTH;

        if (\is_int($minimumLastnameLength)) {
            UserConfiguration::setMinimumLastnameLength($minimumLastnameLength);
        }

        $maximumLastnameLength = $container->hasParameter('app.maximum_lastname_length')
            ? $container->getParameter('app.maximum_lastname_length')
            : UserConfiguration::DEFAULT_LASTNAME_MAXIMUM_LENGTH;

        if (\is_int($maximumLastnameLength)) {
            UserConfiguration::setMaximumLastnameLength($maximumLastnameLength);
        }
    }
}
