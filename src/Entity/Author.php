<?php

namespace App\Entity;

use App\BusinessLogic\Domain\Entity\Author as DomainAuthor;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Doctrine entity Author
 *
 * @package App\Entity
 * @author davamigo@gmail.com
 * @ORM\Table(name="author")
 * @ORM\Entity()
 */
class Author
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
     * @ORM\Column(name="first_name", type="string", length=128, nullable=false)
     * @Assert\NotBlank(groups={"insert", "update"})
     * @Assert\Length(max="128", groups={"insert", "update"})
     */
    private $firstName = null;

    /**
     * @var string
     * @ORM\Column(name="last_name", type="string", length=128, nullable=false)
     * @Assert\NotBlank(groups={"insert", "update"})
     * @Assert\Length(max="128", groups={"insert", "update"})
     */
    private $lastName = null;

    /**
     * @var \DateTime
     * @ORM\Column(name="born_date", type="date", nullable=true)
     * @Assert\Type("\DateTime", groups={"insert", "update"})
     */
    private $bornDate = null;

    /**
     * @var \DateTime
     * @ORM\Column(name="died_date", type="date", nullable=true)
     * @Assert\Type("\DateTime", groups={"insert", "update"})
     */
    private $diedDate = null;

    /**
     * @return DomainAuthor
     */
    public function toDomainEntity() : DomainAuthor
    {
        return new DomainAuthor(
            $this->firstName,
            $this->lastName,
            $this->bornDate,
            $this->diedDate,
            $this->uuid
        );
    }

    /**
     * @param DomainAuthor $author
     * @return Author
     */
    public function fromDomainEntity(DomainAuthor $author): Author
    {
        return $this
            ->setUuid($author->uuid()->toString())
            ->setFirstName($author->firstName())
            ->setLastName($author->lastName())
            ->setBornDate($author->bornDate())
            ->setDiedDate($author->diedDate());
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
     * @return Author
     */
    public function setUuid($uuid): Author
    {
        $this->uuid = $uuid;
        return $this;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     * @return Author
     */
    public function setFirstName($firstName): Author
    {
        $this->firstName = $firstName;
        return $this;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     * @return Author
     */
    public function setLastName($lastName): Author
    {
        $this->lastName = $lastName;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getBornDate()
    {
        return $this->bornDate;
    }

    /**
     * @param \DateTime $bornDate
     * @return Author
     */
    public function setBornDate($bornDate): Author
    {
        $this->bornDate = $bornDate;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDiedDate()
    {
        return $this->diedDate;
    }

    /**
     * @param \DateTime $diedDate
     * @return Author
     */
    public function setDiedDate($diedDate): Author
    {
        $this->diedDate = $diedDate;
        return $this;
    }
}
