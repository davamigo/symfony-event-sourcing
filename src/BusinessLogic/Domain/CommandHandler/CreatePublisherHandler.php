<?php

namespace App\BusinessLogic\Domain\CommandHandler;

use App\BusinessLogic\Domain\Command\CreatePublisher;
use App\BusinessLogic\Domain\Event\PublisherCreated;
use Davamigo\Domain\Core\Command\Command;
use Davamigo\Domain\Core\CommandHandler\CommandHandler;
use Davamigo\Domain\Core\CommandHandler\CommandHandlerException;
use Davamigo\Domain\Core\EventBus\EventBus;

/**
 * Create publisher command handler
 *
 * @package App\BusinessLogic\Application\CommandHandler
 * @author davamigo@gmail.com
 */
class CreatePublisherHandler implements CommandHandler
{
    /** @var EventBus */
    protected $eventBus;

    /**
     * CreatePublisherHandler constructor.
     *
     * @param EventBus $eventBus
     */
    public function __construct(EventBus $eventBus)
    {
        $this->eventBus = $eventBus;
    }

    /**
     * Handles a command.
     *
     * @param Command $command
     * @return void
     * @throws CommandHandlerException
     */
    public function handle(Command $command): void
    {
        if (!$command instanceof CreatePublisher) {
            throw new CommandHandlerException('The command class should be: ' . CreatePublisher::class);
        }

        $this->eventBus->publishEvent(new PublisherCreated($command->publisher()));
    }

    /**
     * Return the names of the commands who handle this command handler
     *
     * @return string[]|string|null
     */
    public function handledCommands()
    {
        return CreatePublisher::class;
    }
}
