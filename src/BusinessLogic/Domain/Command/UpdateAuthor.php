<?php

namespace App\BusinessLogic\Domain\Command;

use App\BusinessLogic\Domain\Entity\Author;
use Davamigo\Domain\Core\Command\CommandBase;
use Davamigo\Domain\Core\Command\CommandException;
use Davamigo\Domain\Core\Serializable\SerializableTrait;
use Davamigo\Domain\Core\Uuid\Uuid;

/**
 * Command Update Author
 *
 * @package App\BusinessLogic\Domain\Command
 * @author davamigo@gmail.com
 */
class UpdateAuthor extends CommandBase
{
    /**
     * UpdateAuthor constructor.
     *
     * @param Author|null      $author
     * @param array            $metadata
     * @param \DateTime        $createdAt
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
            $author,
            $metadata,
            $createdAt,
            $uuid
        );
    }

    /**
     * Get the author from payload
     *
     * @return Author
     * @throws CommandException
     */
    public function author() : Author
    {
        $author = $this->payload();
        if (!$author instanceof Author) {
            throw new CommandException('The payload of the command does not contain an author.');
        }
        return $author;
    }

    /**
     * @method create
     * @method serialize
     */
    use SerializableTrait;
}
