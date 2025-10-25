<?php

namespace App\Entity;

use App\Repository\AuthorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AuthorRepository::class)]
class Author
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $username = null;

    #[ORM\Column(length: 150)]
    private ?string $email = null;

    /**
     * @var Collection<int, Book>
     */
    #[ORM\OneToMany(targetEntity: Book::class, mappedBy: 'id_author')]
    private Collection $books;

    /**
     * @var Collection<int, Book>
     */
    #[ORM\OneToMany(targetEntity: Book::class, mappedBy: 'author_id')]
    private Collection $book_ids;

    public function __construct()
    {
        $this->books = new ArrayCollection();
        $this->book_ids = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return Collection<int, Book>
     */
    public function getBooks(): Collection
    {
        return $this->books;
    }

    /**
     * @return Collection<int, Book>
     */
    public function getBookIds(): Collection
    {
        return $this->book_ids;
    }

    public function addBookId(Book $bookId): static
    {
        if (!$this->book_ids->contains($bookId)) {
            $this->book_ids->add($bookId);
            $bookId->setAuthorId($this);
        }

        return $this;
    }

    public function removeBookId(Book $bookId): static
    {
        if ($this->book_ids->removeElement($bookId)) {
            // set the owning side to null (unless already changed)
            if ($bookId->getAuthorId() === $this) {
                $bookId->setAuthorId(null);
            }
        }

        return $this;
    }

  
    
}
