<?php

namespace App\Command;

use Davamigo\Domain\Core\EventConsumer\EventConsumer;
use Davamigo\Domain\Core\EventStorage\EventStorage;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Exception\LogicException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Command class for event storer daemon
 *
 * @package App\Command
 * @author davamigo@gmail.com
 */
class EventStorageDaemonCommand extends Command
{
    /** @var EventConsumer */
    private $consumer;

    /** @var EventStorage */
    private $storage;

    /**
     * EventStorageDaemonCommand constructor.
     *
     * @param EventConsumer $consumer
     * @param EventStorage $storage
     */
    public function __construct(EventConsumer $consumer, EventStorage $storage)
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
        /** @var Callable $callable */
        $callable = [$this->storage, 'storeEvent'];

        // Start listening the queue
        $this->consumer->listen('app.events.storage', $callable);

        return 0;
    }
}
