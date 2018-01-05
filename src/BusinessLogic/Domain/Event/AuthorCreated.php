<?php

namespace App\BusinessLogic\Domain\Event;

use App\BusinessLogic\Domain\Entity\Author;
use Davamigo\Domain\Core\Event\EventBase;
use Davamigo\Domain\Core\Serializable\SerializableTrait;
use Davamigo\Domain\Core\Uuid\Uuid;

/**
 * Event Author Created
 *
 * @package App\BusinessLogic\Domain\Event
 * @author davamigo@gmail.com
 */
class AuthorCreated extends EventBase
{
    /**
     * AuthorCreated constructor.
     *
     * @param Author|null      $author
     * @param string|null      $topic
     * @param string|null      $routingKey
     * @param Uuid|string|null $uuid
     * @param \DateTime|null   $createdAt
     * @param array            $metadata
     */
    public function __construct(
        Author $author = null,
        $topic = null,
        $routingKey = null,
        $uuid = null,
        \DateTime $createdAt = null,
        array $metadata = []
    ) {
        $name = self::class;
        $author = $author ?: new Author();
        parent::__construct($name, $author, $topic, $routingKey, $uuid, $createdAt, $metadata);
    }

    /**
     * @method create
     * @method serialize
     */
    use SerializableTrait;
}
