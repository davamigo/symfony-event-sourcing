<?php

namespace App\BusinessLogic\Domain\Entity;

use Davamigo\Domain\Core\Entity\EntityBase;
use Davamigo\Domain\Core\Serializable\SerializableTrait;
use Davamigo\Domain\Core\Uuid\Uuid;

/**
 * Entity Publisher
 *
 * @package App\BusinessLogic\Domain\Entity
 * @author davamigo@gmail.com
 */
class Publisher extends EntityBase
{
    /** @var string */
    private $name;

    /**
     * @return string
     */
    public function name()
    {
        return $this->name;
    }

    /**
     * Publisher constructor
     *
     * @param string|null      $name
     * @param Uuid|string|null $uuid
     */
    public function __construct(
        string $name = null,
        $uuid = null
    ) {
        parent::__construct($uuid);
        $this->name = $name;
    }

    /**
     * @method create
     * @method serialize
     */
    use SerializableTrait;
}
