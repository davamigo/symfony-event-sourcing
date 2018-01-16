<?php

namespace App\Command;

use Davamigo\Domain\Core\EventConsumer\EventConsumer;
use Davamigo\Infrastructure\Core\EventHandler\DoctrinePersistEntityEventHandler;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Exception\LogicException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Command class for event storage daemon: stores the entities inside the events into a MySQL database
 *
 * @package App\Command
 * @author davamigo@gmail.com
 */
class DatabaseUpdaterDaemonCommand extends Command
{
    /** @var EventConsumer */
    private $consumer;

    /** @var DoctrinePersistEntityEventHandler */
    private $persister;

    /**
     * EventStorageDaemonCommand constructor.
     *
     * @param EventConsumer                     $consumer
     * @param DoctrinePersistEntityEventHandler $persister
     */
    public function __construct(EventConsumer $consumer, DoctrinePersistEntityEventHandler $persister)
    {
        parent::__construct();
        $this->consumer = $consumer;
        $this->persister = $persister;
    }

    /**
     * Configures the current command.
     */
    protected function configure()
    {
        $this
            ->setName('app:database-updater-daemon')
            ->setDescription('Starts the database updater daemon.')
            ->setHelp('This command starts the database updater daemon who updates the MySQL database.');
    }

    /**
     * Executes the current command.
     *
     * This method is not abstract because you can use this class
     * as a concrete class. In this case, instead of defining the
     * execute() method, you set the code to execute by passing
     * a Closure to the setCode() method.
     *
     * @return null|int null or 0 if everything went fine, or an error code
     *
     * @throws LogicException When this abstract method is not implemented
     *
     * @see setCode()
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Start listening the queue
        $this->consumer->listen('app.events.model', $this->persister);

        return 0;
    }
}
