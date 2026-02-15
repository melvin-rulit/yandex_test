<?php

namespace App\Http\Controllers;

use App\Http\Resources\YandexReviewResource;
use App\Services\YandexReviewService;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    protected YandexReviewService $reviewService;

    public function __construct(YandexReviewService $reviewService)
    {
        $this->reviewService = $reviewService;
    }

    /**
     * @throws ConnectionException
     */
    public function getReviewsForUser(): YandexReviewResource
    {
        $reviews = $this->reviewService->getReviewsForUser(Auth::id());

        return new YandexReviewResource($reviews);
    }
}

