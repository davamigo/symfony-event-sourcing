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
     * @param Uuid|string|null $uuid
     * @param string|null      $name
     */
    public function __construct($uuid = null, string $name = null)
    {
        parent::__construct($uuid);
        $this->name = $name;
    }

    /**
     * @method create
     * @method serialize
     */
    use SerializableTrait;
}
