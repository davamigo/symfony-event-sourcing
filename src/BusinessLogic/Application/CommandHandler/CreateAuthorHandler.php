<?php

namespace App\BusinessLogic\Application\CommandHandler;

use App\BusinessLogic\Domain\Command\CreateAuthor;
use Davamigo\Domain\Core\Command\Command;
use Davamigo\Domain\Core\Command\CommandHandler;
use Davamigo\Domain\Core\Command\CommandHandlerException;
use Davamigo\Domain\Core\Event\EventBus;

/**
 * Create author command handler
 *
 * @package App\BusinessLogic\Application\CommandHandler
 * @author davamigo@gmail.com
 */
class CreateAuthorHandler implements CommandHandler
{
    /** @var EventBus */
    protected $eventBus;

    /**
     * CreateAuthorHandler constructor.
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
        if (!$command instanceof CreateAuthor) {
            throw new CommandHandlerException('The command class should be: ' . CreateAuthor::class);
        }

        // TODO
        echo 'Hello world';
    }
}
