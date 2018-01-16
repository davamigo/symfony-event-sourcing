<?php

namespace App\Command;

use Davamigo\Domain\Core\EventConsumer\EventConsumer;
use Davamigo\Infrastructure\Core\EventHandler\MongoDBEventStorageHandler;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Exception\LogicException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Command class for event storage daemon: stores the events in the event storage
 *
 * @package App\Command
 * @author davamigo@gmail.com
 */
class EventStorageDaemonCommand extends Command
{
    /** @var EventConsumer */
    private $consumer;

    /** @var MongoDBEventStorageHandler */
    private $storage;

    /**
     * EventStorageDaemonCommand constructor.
     *
     * @param EventConsumer              $consumer
     * @param MongoDBEventStorageHandler $storage
     */
    public function __construct(EventConsumer $consumer, MongoDBEventStorageHandler $storage)
    {
        parent::__construct();
        $this->consumer = $consumer;
        $this->storage = $storage;
    }

    /**
     * Configures the current command.
     */
    protected function configure()
    {
        $this
            ->setName('app:event-storage-consumer-daemon')
            ->setDescription('Starts the event storage consumer daemon.')
            ->setHelp('This command starts the event storage consumer daemon who consumes the events from the queue.');
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
        $this->consumer->listen('app.events.storage', $this->storage);

        return 0;
    }
}
