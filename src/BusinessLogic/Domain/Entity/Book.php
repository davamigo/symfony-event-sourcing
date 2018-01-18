<?php

namespace App\BusinessLogic\Domain\Entity;

use Davamigo\Domain\Core\Entity\EntityBase;
use Davamigo\Domain\Core\Serializable\Serializable;
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

    /** @var \DateTime */
    private $releaseDate;

    /** @var Publisher */
    private $publisher;

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
     * @return \DateTime
     */
    public function releaseDate()
    {
        return $this->releaseDate;
    }

    /**
     * @return Publisher
     */
    public function publisher()
    {
        return $this->publisher;
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
     * @param string|null      $name
     * @param \DateTime|null   $releaseDate
     * @param Publisher|null   $publisher
     * @param Author[]         $authors
     * @param Uuid|string|null $uuid
     */
    public function __construct(
        string $name = null,
        \DateTime $releaseDate = null,
        Publisher $publisher = null,
        array $authors = [],
        $uuid = null
    ) {
        parent::__construct($uuid);
        $this->name = $name;
        $this->releaseDate = $releaseDate;
        $this->publisher = $publisher;
        $this->authors = $authors;
    }

    /**
     * Creates a serializable object from an array
     *
     * @param array $data
     * @return Serializable
     */
    public static function create(array $data) : Serializable
    {
        $name = $data['name'] ?? null;
        $releaseDate = $data['releaseDate'] ?? null;
        $publisher = $data['publisher'] ?? null;
        $authors = array_map(
            function (array $author) {
                return Author::create($author);
            },
            $data['authors'] ?? []
        );
        $uuid = $data['uuid'] ?? null;

        if (null !== $publisher) {
            $publisher = Publisher::create($publisher);
        }

        if (null !== $releaseDate) {
            $releaseDate = \DateTime::createFromFormat(\DateTime::RFC3339, $releaseDate);
        }

        return new static(
            $name,
            $releaseDate,
            $publisher,
            $authors,
            $uuid
        );
    }

    /**
     * Serializes the object to an array
     *
     * @return array
     */
    public function serialize() : array
    {
        $theReleaseDate = (null == $this->releaseDate()) ? null : $this->releaseDate()->format(\DateTime::RFC3339);

        $thePublisher = (null == $this->publisher) ? null : $this->publisher()->serialize();

        $theAuthors = array_map(
            function (Author $author) {
                return $author->serialize();
            },
            $this->authors()
        );

        return [
            'uuid'          => $this->uuid()->toString(),
            'name'          => $this->name(),
            'releaseDate'   => $theReleaseDate,
            'publisher'     => $thePublisher,
            'authors'       => $theAuthors
        ];
    }
}
