<?php

namespace App\Entity;

use App\BusinessLogic\Domain\Entity\Book as DomainBook;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Doctrine entity Book
 *
 * @package App\Entity
 * @author davamigo@gmail.com
 * @ORM\Table(name="book")
 * @ORM\Entity()
 */
class Book
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
     * @var \DateTime
     * @ORM\Column(name="release_date", type="date", nullable=true)
     * @Assert\Type("\DateTime", groups={"insert", "update"})
     */
    private $releaseDate = null;

    /**
     * @var Publisher
     * @ORM\ManyToOne(targetEntity="Publisher")
     * @ORM\JoinColumn(name="publisher_uuid", referencedColumnName="uuid", nullable=true)
     */
    private $publisher = null;

    /**
     * @var Collection
     * @ORM\ManyToMany(targetEntity="Author")
     * @ORM\JoinTable(name="written",
     *     joinColumns={@ORM\JoinColumn(name="book_uuid", referencedColumnName="uuid")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="author_uuid", referencedColumnName="uuid")}
     * )
     */
    private $authors;

    /**
     * Book constructor.
     */
    public function __construct()
    {
        $this->authors = new ArrayCollection();
    }

    /**
     * @return DomainBook
     */
    public function toDomainEntity() : DomainBook
    {
        $thePublisher = null;
        if (null !== $this->publisher) {
            $thePublisher = $this->publisher->toDomainEntity();
        }

        $theAuthors = array_map(
            function (Author $author) {
                return $author->toDomainEntity();
            },
            $this->authors->toArray()
        );

        return new DomainBook(
            $this->name,
            $this->releaseDate,
            $thePublisher,
            $theAuthors,
            $this->uuid
        );
    }

    /**
     * @param DomainBook $book
     * @return Book
     */
    public function fromDomainEntity(DomainBook $book): Book
    {
        $this
            ->setUuid($book->uuid()->toString())
            ->setName($book->name())
            ->setReleaseDate($book->releaseDate());

        $thePublisher = $book->publisher();
        if (null === $thePublisher) {
            $this->setPublisher(null);
        } else {
            $pub = $this->getPublisher();
            if (null === $pub) {
                $pub = new Publisher();
            }
            $pub->fromDomainEntity($thePublisher);
            $this->setPublisher($pub);
        }

        /** @var Author $author */
        foreach ($this->getAuthors() as $author) {
            $found = false;
            foreach ($book->authors() as $domainAuthor) {
                if ($author->getUuid() == $domainAuthor->uuid()->toString()) {
                    $author->fromDomainEntity($domainAuthor);
                    $found = true;
                    break;
                }
            }
            if (!$found) {
                $theAuthor = new Author();
                $theAuthor->fromDomainEntity($domainAuthor);
                $this->addAuthor($theAuthor);
            }
        }

        return $this;
    }

    /**
     * @return string|null
     */
    public function getUuid() : ?string
    {
        return $this->uuid;
    }

    /**
     * @param string $uuid
     * @return Book
     */
    public function setUuid($uuid): Book
    {
        $this->uuid = $uuid;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getName() : ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Book
     */
    public function setName($name): Book
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getReleaseDate() : ?\DateTime
    {
        return $this->releaseDate;
    }

    /**
     * @param \DateTime $releaseDate
     * @return Book
     */
    public function setReleaseDate($releaseDate = null): Book
    {
        $this->releaseDate = $releaseDate;
        return $this;
    }

    /**
     * @return Publisher
     */
    public function getPublisher(): ?Publisher
    {
        return $this->publisher;
    }

    /**
     * @param Publisher $publisher
     * @return Book
     */
    public function setPublisher(Publisher $publisher = null): Book
    {
        $this->publisher = $publisher;
        return $this;
    }

    /**
     * @return Collection
     */
    public function getAuthors(): Collection
    {
        return $this->authors;
    }

    /**
     * @param Author $author
     * @return Book
     */
    public function addAuthor(Author $author) : Book
    {
        $this->authors->add($author);
        return $this;
    }
}
