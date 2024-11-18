<?php

namespace App;

use Shared\Application\Command\CommandHandlerInterface;
use Shared\Application\Query\QueryHandlerInterface;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use User\Infrastructure\CompilerPass\UserConfigurationPass;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    protected function build(ContainerBuilder $container): void
    {
        parent::build($container);

        $container->registerForAutoconfiguration(CommandHandlerInterface::class)
            ->addTag('messenger.message_handler', ['bus' => 'messenger.bus.command']);

        $container->registerForAutoconfiguration(QueryHandlerInterface::class)
            ->addTag('messenger.message_handler', ['bus' => 'messenger.bus.query']);

        $container->addCompilerPass(new UserConfigurationPass());
    }
}
