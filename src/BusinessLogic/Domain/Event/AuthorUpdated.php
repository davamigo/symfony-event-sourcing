<?php

namespace App\BusinessLogic\Domain\Event;

use App\BusinessLogic\Domain\Entity\Author;
use Davamigo\Domain\Core\Event\Event;
use Davamigo\Domain\Core\Event\EventBase;
use Davamigo\Domain\Core\Event\EventException;
use Davamigo\Domain\Core\Serializable\SerializableTrait;
use Davamigo\Domain\Core\Uuid\Uuid;

/**
 * Event Author Updated
 *
 * @package App\BusinessLogic\Domain\Event
 * @author davamigo@gmail.com
 */
class AuthorUpdated extends EventBase
{
    /**
     * AuthorUpdated constructor.
     *
     * @param Author|null      $author
     * @param array            $metadata
     * @param \DateTime|null   $createdAt
     * @param Uuid|string|null $uuid
     */
    public function __construct(
        Author $author = null,
        array $metadata = [],
        \DateTime $createdAt = null,
        $uuid = null
    ) {
        $author = $author ?: new Author();
        parent::__construct(
            self::class,
            Event::ACTION_UPDATE,
            $author,
            $metadata,
            $createdAt,
            $uuid
        );
    }

    /**
     * Get the author
     *
     * @return Author
     * @throws EventException
     */
    public function author() : Author
    {
        $author = $this->payload();
        if (!$author instanceof Author) {
            throw new EventException('The payload of the event does not contain an author.');
        }
        return $author;
    }

    /**
     * @method create
     * @method serialize
     */
    use SerializableTrait;
}
