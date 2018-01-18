<?php

namespace App\Entity;

use App\BusinessLogic\Domain\Entity\Publisher as DomainPublisher;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Doctrine entity Publisher
 *
 * @package App\Entity
 * @author davamigo@gmail.com
 * @ORM\Table(name="publisher")
 * @ORM\Entity()
 */
class Publisher
{
    /**
     * @var string
     * @ORM\Id
     * @ORM\Column(type="string", length=36, nullable=false)
     * @Assert\NotBlank(groups={"update", "delete"})
     * @Assert\Length(min="36", max="36", groups={"update", "delete"})
     */
    private $uuid = null;

    /**
     * @var string
     * @ORM\Column(name="name", type="string", length=128, nullable=false)
     * @Assert\NotBlank(groups={"insert", "update"})
     * @Assert\Length(max="128", groups={"insert", "update"})
     */
    private $name = null;

    /**
     * @return DomainPublisher
     */
    public function toDomainEntity() : DomainPublisher
    {
        return new DomainPublisher(
            $this->name,
            $this->uuid
        );
    }

    /**
     * @param DomainPublisher $publisher
     * @return Publisher
     */
    public function fromDomainEntity(DomainPublisher $publisher): Publisher
    {
        return $this
            ->setUuid($publisher->uuid()->toString())
            ->setName($publisher->name());
    }

    /**
     * @return string
     */
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * @param string $uuid
     * @return Publisher
     */
    public function setUuid($uuid): Publisher
    {
        $this->uuid = $uuid;
        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Publisher
     */
    public function setName($name): Publisher
    {
        $this->name = $name;
        return $this;
    }
}
