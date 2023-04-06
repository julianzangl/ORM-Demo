<?php

namespace App\Entity;

use App\Repository\QuoteRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: QuoteRepository::class)]
class Quote
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length(min: 3, max: 255)]
    private ?string $quote = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length(min: 3, max: 255)]
    private ?string $character_name = null;

    #[ORM\ManyToOne(inversedBy: 'quotes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Movie $movie = null;

    #[Assert\Type(type: 'integer')]
    #[Assert\Range(min: 1, max: 100)]
    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $times_said = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $magic_string = null;

    #[Assert\IsTrue(message: "Each character in the magic string must appear exactly twice")]
        private function hasOnlyDoubleChars(): bool
        {
            $charCount = count_chars($this->magic_string, 1);
            foreach ($charCount as $char => $count) {
                if ($count !== 2) {
                    return false;
                }
            }
            return true;
        }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuote(): ?string
    {
        return $this->quote;
    }

    public function setQuote(string $quote): self
    {
        $this->quote = $quote;

        return $this;
    }

    public function getCharacterName(): ?string
    {
        return $this->character_name;
    }

    public function setCharacterName(string $character_name): self
    {
        $this->character_name = $character_name;

        return $this;
    }

    public function getMovie(): ?Movie
    {
        return $this->movie;
    }

    public function setMovie(?Movie $movie): self
    {
        $this->movie = $movie;

        return $this;
    }

    public function getTimesSaid(): ?int
    {
        return $this->times_said;
    }

    public function setTimesSaid(?int $times_said): self
    {
        $this->times_said = $times_said;

        return $this;
    }

    public function getMagicString(): ?string
    {
        return $this->magic_string;
    }

    public function setMagicString(?string $magic_string): self
    {
        $this->magic_string = $magic_string;

        return $this;
    }

    public function __toString(): string
    {
        return $this->getQuote();
    }
}
