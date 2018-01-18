<?php

namespace App\BusinessLogic\Domain\Command;

use App\BusinessLogic\Domain\Entity\Publisher;
use Davamigo\Domain\Core\Command\CommandBase;
use Davamigo\Domain\Core\Command\CommandException;
use Davamigo\Domain\Core\Serializable\SerializableTrait;
use Davamigo\Domain\Core\Uuid\Uuid;

/**
 * Command to create a publisher
 *
 * @package App\BusinessLogic\Domain\Command
 * @author davamigo@gmail.com
 */
class CreatePublisher extends CommandBase
{
    /**
     * CreatePublisher constructor.
     *
     * @param Publisher|null   $Publisher
     * @param array            $metadata
     * @param \DateTime        $createdAt
     * @param Uuid|string|null $uuid
     */
    public function __construct(
        Publisher $Publisher = null,
        array $metadata = [],
        \DateTime $createdAt = null,
        $uuid = null
    ) {
        $Publisher = $Publisher ?: new Publisher();
        parent::__construct(
            self::class,
            $Publisher,
            $metadata,
            $createdAt,
            $uuid
        );
    }

    /**
     * Get the publisher from payload
     *
     * @return Publisher
     * @throws CommandException
     */
    public function publisher() : Publisher
    {
        $publisher = $this->payload();
        if (!$publisher instanceof Publisher) {
            throw new CommandException('The payload of the command does not contain an Publisher.');
        }
        return $publisher;
    }

    /**
     * @method create
     * @method serialize
     */
    use SerializableTrait;
}
