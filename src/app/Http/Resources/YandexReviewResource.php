<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;


class YandexReviewResource extends JsonResource
{
    public static $wrap = null;

    public function toArray($request)
    {
        return $this->resource;
    }
}
