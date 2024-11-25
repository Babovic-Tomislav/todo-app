<?php

namespace App;

use Shared\Application\Command\CommandHandlerInterface;
use Shared\Application\Query\QueryHandlerInterface;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Todo\Infrastructure\CompilerPass\TodoListConfigurationPass;
use Todo\Infrastructure\CompilerPass\TodoListItemConfigurationPass;
use User\Infrastructure\CompilerPass\UserConfigurationPass;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    public function getCompilerPasses(ContainerBuilder $container): void
    {
        $container->addCompilerPass(new UserConfigurationPass());
        $container->addCompilerPass(new TodoListConfigurationPass());
        $container->addCompilerPass(new TodoListItemConfigurationPass());
    }

    protected function build(ContainerBuilder $container): void
    {
        parent::build($container);

        $container->registerForAutoconfiguration(CommandHandlerInterface::class)
            ->addTag('messenger.message_handler', ['bus' => 'messenger.bus.command']);

        $container->registerForAutoconfiguration(QueryHandlerInterface::class)
            ->addTag('messenger.message_handler', ['bus' => 'messenger.bus.query']);

        $this->getCompilerPasses($container);
    }
}
