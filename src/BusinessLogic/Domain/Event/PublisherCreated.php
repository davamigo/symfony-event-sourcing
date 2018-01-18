<?php

namespace App\BusinessLogic\Domain\Event;

use App\BusinessLogic\Domain\Entity\Publisher;
use Davamigo\Domain\Core\Event\Event;
use Davamigo\Domain\Core\Event\EventBase;
use Davamigo\Domain\Core\Event\EventException;
use Davamigo\Domain\Core\Serializable\SerializableTrait;
use Davamigo\Domain\Core\Uuid\Uuid;

/**
 * Event Publisher Created
 *
 * @package App\BusinessLogic\Domain\Event
 * @author davamigo@gmail.com
 */
class PublisherCreated extends EventBase
{
    /**
     * PublisherCreated constructor.
     *
     * @param Publisher|null   $publisher
     * @param array            $metadata
     * @param \DateTime|null   $createdAt
     * @param Uuid|string|null $uuid
     */
    public function __construct(
        Publisher $publisher = null,
        array $metadata = [],
        \DateTime $createdAt = null,
        $uuid = null
    ) {
        $publisher = $publisher ?: new Publisher();
        parent::__construct(
            self::class,
            Event::ACTION_INSERT,
            $publisher,
            $metadata,
            $createdAt,
            $uuid
        );
    }

    /**
     * Get the publisher
     *
     * @return Publisher
     * @throws EventException
     */
    public function publisher() : Publisher
    {
        $publisher = $this->payload();
        if (!$publisher instanceof Publisher) {
            throw new EventException('The payload of the event does not contain a publisher.');
        }
        return $publisher;
    }

    /**
     * @method create
     * @method serialize
     */
    use SerializableTrait;
}
