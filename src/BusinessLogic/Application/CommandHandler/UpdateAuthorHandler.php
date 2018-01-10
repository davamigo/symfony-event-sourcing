<?php

namespace App\BusinessLogic\Application\CommandHandler;

use App\BusinessLogic\Domain\Command\UpdateAuthor;
use App\BusinessLogic\Domain\Event\AuthorUpdated;
use Davamigo\Domain\Core\Command\Command;
use Davamigo\Domain\Core\CommandHandler\CommandHandler;
use Davamigo\Domain\Core\CommandHandler\CommandHandlerException;
use Davamigo\Domain\Core\EventBus\EventBus;

/**
 * Update author command handler
 *
 * @package App\BusinessLogic\Application\CommandHandler
 * @author davamigo@gmail.com
 */
class UpdateAuthorHandler implements CommandHandler
{
    /** @var EventBus */
    protected $eventBus;

    /**
     * UpdateAuthorHandler constructor.
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
        if (!$command instanceof UpdateAuthor) {
            throw new CommandHandlerException('The command class should be: ' . UpdateAuthor::class);
        }

        $this->eventBus->publishEvent(new AuthorUpdated($command->author()));
    }

    /**
     * Return the names of the commands who handle this command handler
     *
     * @return string[]|string|null
     */
    public function handledCommands()
    {
        return UpdateAuthor::class;
    }
}
