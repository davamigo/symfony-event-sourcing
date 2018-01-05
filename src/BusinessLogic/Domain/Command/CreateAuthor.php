<?php

namespace App\BusinessLogic\Domain\Command;

use App\BusinessLogic\Domain\Entity\Author;
use Davamigo\Domain\Core\Command\CommandBase;
use Davamigo\Domain\Core\Serializable\SerializableTrait;
use Davamigo\Domain\Core\Uuid\Uuid;

/**
 * Command Create Author
 *
 * @package App\BusinessLogic\Domain\Command
 * @author davamigo@gmail.com
 */
class CreateAuthor extends CommandBase
{
    /**
     * CreateAuthor constructor.
     *
     * @param Author|null      $author
     * @param Uuid|string|null $uuid
     * @param \DateTime        $createdAt
     * @param array            $metadata
     */
    public function __construct(
        Author $author = null,
        $uuid = null,
        \DateTime $createdAt = null,
        array $metadata = []
    ) {
        $name = self::class;
        $author = $author ?: new Author();
        parent::__construct($name, $author, $uuid, $createdAt, $metadata);
    }

    /**
     * @method create
     * @method serialize
     */
    use SerializableTrait;
}
