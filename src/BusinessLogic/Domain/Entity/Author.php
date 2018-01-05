<?php

namespace App\BusinessLogic\Domain\Entity;

use Davamigo\Domain\Core\Entity\EntityBase;
use Davamigo\Domain\Core\Serializable\SerializableTrait;
use Davamigo\Domain\Core\Uuid\Uuid;

/**
 * Entity Author
 *
 * @package App\BusinessLogic\Domain\Entity
 * @author davamigo@gmail.com
 */
class Author extends EntityBase
{
    /** @var string */
    private $firstName;

    /** @var string */
    private $lastName;

    /**
     * @return string
     */
    public function firstName()
    {
        return $this->firstName;
    }

    /**
     * @return string
     */
    public function lastName()
    {
        return $this->lastName;
    }

    /**
     * Author constructor
     *
     * @param Uuid|string|null $uuid
     * @param string|null      $firstName
     * @param string|null      $lastName
     */
    public function __construct(
        $uuid = null,
        string $firstName = null,
        string $lastName = null
    ) {
        parent::__construct($uuid);
        $this->firstName = $firstName;
        $this->lastName = $lastName;
    }

    /**
     * @method create
     * @method serialize
     */
    use SerializableTrait;
}
