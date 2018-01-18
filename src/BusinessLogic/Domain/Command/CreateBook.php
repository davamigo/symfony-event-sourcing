<?php

namespace App\BusinessLogic\Domain\Command;

use App\BusinessLogic\Domain\Entity\Book;
use Davamigo\Domain\Core\Command\CommandBase;
use Davamigo\Domain\Core\Command\CommandException;
use Davamigo\Domain\Core\Serializable\SerializableTrait;
use Davamigo\Domain\Core\Uuid\Uuid;

/**
 * Command to create a book
 *
 * @package App\BusinessLogic\Domain\Command
 * @author davamigo@gmail.com
 */
class CreateBook extends CommandBase
{
    /**
     * CreateBook constructor.
     *
     * @param Book|null        $book
     * @param array            $metadata
     * @param \DateTime        $createdAt
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
            $book,
            $metadata,
            $createdAt,
            $uuid
        );
    }

    /**
     * Get the book from payload
     *
     * @return Book
     * @throws CommandException
     */
    public function book() : Book
    {
        $book = $this->payload();
        if (!$book instanceof Book) {
            throw new CommandException('The payload of the command does not contain an Book.');
        }
        return $book;
    }

    /**
     * @method create
     * @method serialize
     */
    use SerializableTrait;
}
