<?php

namespace App\BusinessLogic\Domain\Entity;

use Davamigo\Domain\Core\Entity\EntityBase;
use Davamigo\Domain\Core\Serializable\SerializableTrait;
use Davamigo\Domain\Core\Uuid\Uuid;

/**
 * Entity Book
 *
 * @package App\BusinessLogic\Domain\Entity
 * @author davamigo@gmail.com
 */
class Book extends EntityBase
{
    /** @var string */
    private $name;

    /** @var Publisher */
    private $publisher;

    /** @var \DateTime */
    private $releaseDate;

    /** @var Author[] */
    private $authors;

    /**
     * @return string
     */
    public function name()
    {
        return $this->name;
    }

    /**
     * @return Publisher
     */
    public function publisher()
    {
        return $this->publisher;
    }

    /**
     * @return \DateTime
     */
    public function releaseDate()
    {
        return $this->releaseDate;
    }

    /**
     * @return Author[]
     */
    public function authors()
    {
        return $this->authors;
    }

    /**
     * Book constructor.
     *
     * @param Uuid|string|null $uuid
     * @param string|null      $name
     * @param Publisher|null   $publisher
     * @param \DateTime|null   $releaseDate
     * @param Author[]         $authors
     */
    public function __construct(
        $uuid = null,
        string $name = null,
        Publisher $publisher = null,
        \DateTime $releaseDate = null,
        array $authors = []
    ) {
        parent::__construct($uuid);
        $this->name = $name;
        $this->publisher = $publisher ?: new Publisher();
        $this->releaseDate = $releaseDate ?: new \DateTime();
        $this->authors = !empty($authors) ? $authors : [ new Author() ];
    }

    /**
     * @method create
     * @method serialize
     */
    use SerializableTrait;
}
