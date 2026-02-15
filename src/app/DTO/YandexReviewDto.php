<?php

namespace App\DTO;

class YandexReviewDto
{
    public function __construct(
        public string $author,
        public ?float $rating,
        public string $reviewText,
        public ?string $date
    ) {}

    public function getUniqueKey(): string
    {
        return "{$this->author}|{$this->reviewText}|{$this->date}";
    }

    public function toArray(): array
    {
        return [
            'author' => $this->author,
            'rating' => $this->rating,
            'review_text' => $this->reviewText,
            'date' => $this->date,
        ];
    }
}
