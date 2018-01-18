<?php

namespace App\BusinessLogic\Domain\CommandHandler;

use App\BusinessLogic\Domain\Command\UpdateBook;
use App\BusinessLogic\Domain\Event\BookUpdated;
use Davamigo\Domain\Core\Command\Command;
use Davamigo\Domain\Core\CommandHandler\CommandHandler;
use Davamigo\Domain\Core\CommandHandler\CommandHandlerException;
use Davamigo\Domain\Core\EventBus\EventBus;

/**
 * Update book command handler
 *
 * @package App\BusinessLogic\Application\CommandHandler
 * @author davamigo@gmail.com
 */
class UpdateBookHandler implements CommandHandler
{
    /** @var EventBus */
    protected $eventBus;

    /**
     * UpdateBookHandler constructor.
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
        if (!$command instanceof UpdateBook) {
            throw new CommandHandlerException('The command class should be: ' . UpdateBook::class);
        }

        $this->eventBus->publishEvent(new BookUpdated($command->book()));
    }

    /**
     * Return the names of the commands who handle this command handler
     *
     * @return string[]|string|null
     */
    public function handledCommands()
    {
        return UpdateBook::class;
    }
}
