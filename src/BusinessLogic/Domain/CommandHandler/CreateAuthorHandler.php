<?php

namespace App\BusinessLogic\Domain\CommandHandler;

use App\BusinessLogic\Domain\Command\CreateAuthor;
use App\BusinessLogic\Domain\Event\AuthorCreated;
use Davamigo\Domain\Core\Command\Command;
use Davamigo\Domain\Core\CommandHandler\CommandHandler;
use Davamigo\Domain\Core\CommandHandler\CommandHandlerException;
use Davamigo\Domain\Core\EventBus\EventBus;

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

        $this->eventBus->publishEvent(new AuthorCreated($command->author()));
    }

    /**
     * Return the names of the commands who handle this command handler
     *
     * @return string[]|string|null
     */
    public function handledCommands()
    {
        return CreateAuthor::class;
    }
}
