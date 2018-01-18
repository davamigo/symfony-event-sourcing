<?php

namespace App\BusinessLogic\Domain\Event;

use App\BusinessLogic\Domain\Entity\Book;
use Davamigo\Domain\Core\Event\Event;
use Davamigo\Domain\Core\Event\EventBase;
use Davamigo\Domain\Core\Event\EventException;
use Davamigo\Domain\Core\Serializable\SerializableTrait;
use Davamigo\Domain\Core\Uuid\Uuid;

/**
 * Event Book Updated
 *
 * @package App\BusinessLogic\Domain\Event
 * @author davamigo@gmail.com
 */
class BookUpdated extends EventBase
{
    /**
     * BookUpdated constructor.
     *
     * @param Book|null        $book
     * @param array            $metadata
     * @param \DateTime|null   $createdAt
     * @param Uuid|string|null $uuid
     */
    public function __construct(
        Book $book = null,
        array $metadata = [],
        \DateTime $createdAt = null,
        $uuid = null
    ) {
        $book = $book ?: new Book();
        parent::__construct(
            self::class,
            Event::ACTION_UPDATE,
            $book,
            $metadata,
            $createdAt,
            $uuid
        );
    }

    /**
     * Get the book
     *
     * @return Book
     * @throws EventException
     */
    public function book() : Book
    {
        $book = $this->payload();
        if (!$book instanceof Book) {
            throw new EventException('The payload of the event does not contain a book.');
        }
        return $book;
    }

    /**
     * @method create
     * @method serialize
     */
    use SerializableTrait;
}
