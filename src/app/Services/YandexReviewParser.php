<?php

namespace App\Services;

use DOMXPath;
use DOMDocument;
use App\DTO\YandexReviewDto;

class YandexReviewParser
{
    private const MAX_REVIEWS = 10;

    public function parse(string $html): array
    {
        $dom = new DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML($html);
        libxml_clear_errors();

        $xpath = new DOMXPath($dom);

        $companyRatingNode = $xpath->query("//meta[@itemprop='ratingValue']")->item(0);
        $companyRating = $companyRatingNode ? (float) $companyRatingNode->getAttribute('content') : null;

        $ratingCountNode = $xpath->query("//meta[@itemprop='ratingCount']")->item(0);
        $totalReviews = $ratingCountNode ? (int) $ratingCountNode->getAttribute('content') : null;

        $reviewsNodes = $xpath->query("//div[contains(@class, 'business-review-view')]");
        $reviewsData = [];
        $seen = [];

        foreach ($reviewsNodes as $reviewNode) {
            if (count($reviewsData) >= self::MAX_REVIEWS) {
                break;
            }

            $reviewDto = $this->parseSingleReview($xpath, $reviewNode);

            if (!$reviewDto) continue;

            $key = $reviewDto->getUniqueKey();
            if (isset($seen[$key])) continue;

            $seen[$key] = true;
            $reviewsData[] = $reviewDto->toArray();
        }

        return [
            'summary' => [
                'company_rating' => $companyRating,
                'total_reviews' => $totalReviews,
            ],
            'reviews' => $reviewsData,
        ];
    }

    private function parseSingleReview(DOMXPath $xpath, \DOMNode $reviewNode): ?YandexReviewDto
    {
        $authorNode = $xpath->query(".//span[@itemprop='name']", $reviewNode)->item(0);
        $author = $authorNode ? trim($authorNode->textContent) : 'Неизвестно';

        $ratingNode = $xpath->query(".//meta[@itemprop='ratingValue']", $reviewNode)->item(0);
        $rating = $ratingNode ? (float) $ratingNode->getAttribute('content') : null;

        $reviewTextNode = $xpath->query(".//div[contains(@class, 'business-review-view__body')]", $reviewNode)->item(0);
        $reviewText = $reviewTextNode ? trim($reviewTextNode->textContent) : null;

        $dateNode = $xpath->query(".//span[contains(@class,'business-review-view__date')]/meta[@itemprop='datePublished']", $reviewNode)->item(0);
        $date = $dateNode?->getAttribute('content');

        if (!$reviewText) return null;

        return new YandexReviewDto($author, $rating, $reviewText, $date);
    }
}
