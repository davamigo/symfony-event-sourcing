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

    /** @var \DateTime */
    private $bornDate;

    /** @var \DateTime */
    private $diedDate;

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
     * @return \DateTime
     */
    public function bornDate()
    {
        return $this->bornDate;
    }

    /**
     * @return \DateTime
     */
    public function diedDate()
    {
        return $this->diedDate;
    }

    /**
     * @param string $firstName
     * @return Author
     */
    public function setFirstName(string $firstName): Author
    {
        $this->firstName = $firstName;
        return $this;
    }

    /**
     * @param string $lastName
     * @return Author
     */
    public function setLastName(string $lastName): Author
    {
        $this->lastName = $lastName;
        return $this;
    }

    /**
     * @param \DateTime $bornDate
     * @return Author
     */
    public function setBornDate(\DateTime $bornDate): Author
    {
        $this->bornDate = $bornDate;
        return $this;
    }

    /**
     * @param \DateTime $diedDate
     * @return Author
     */
    public function setDiedDate(\DateTime $diedDate): Author
    {
        $this->diedDate = $diedDate;
        return $this;
    }

    /**
     * Author constructor
     *
     * @param Uuid|string|null $uuid
     * @param string|null      $firstName
     * @param string|null      $lastName
     * @param \DateTime|null   $bornDate
     * @param \DateTime|null   $diedDate
     */
    public function __construct(
        $uuid = null,
        string $firstName = null,
        string $lastName = null,
        \DateTime $bornDate = null,
        \DateTime $diedDate = null
    ) {
        parent::__construct($uuid);
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->bornDate = $bornDate;
        $this->diedDate = $diedDate;
    }

    /**
     * @method create
     * @method serialize
     */
    use SerializableTrait;
}
