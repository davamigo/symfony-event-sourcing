<?php

namespace App\EventListener;

use Davamigo\Domain\Core\CommandBus\CommandBus;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;

/**
 * Event listener for kernel.response event
 *
 * @package App\EventListener
 * @author davamigo@gmail.com
 */
class CommandBusDispatcherKernelResponseListener
{
    /** @var CommandBus */
    private $commandBus;

    /**
     * KernelResponseListener constructor.
     *
     * @param CommandBus $commandBus
     */
    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /**
     * @param FilterResponseEvent $event
     */
    public function onKernelResponse()
    {
        $this->commandBus->dispatch();
    }
}
