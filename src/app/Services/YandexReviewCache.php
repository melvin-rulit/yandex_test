<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;

class YandexReviewCache
{
    protected int $cacheMinutes;

    public function __construct()
    {
        $this->cacheMinutes = config('yandex.cache_minutes');
    }

    /**
     * Получает данные из кеша или создаёт их через callback.
     *
     * @param string $key
     * @param callable $callback
     * @return mixed
     */
    public function remember(string $key, callable $callback): mixed
    {
        return Cache::remember($key, now()->addMinutes($this->cacheMinutes), $callback);
    }

    /**
     * Сбрасывает кеш по ключу.
     *
     * @param string $key
     * @return void
     */
    public function forget(string $key): void
    {
        Cache::forget($key);
    }

    /**
     * Генерация ключа кеша на основе user_id и URL.
     *
     * @param int $userId
     * @param string $url
     * @return string
     */
    public function makeKey(int $userId, string $url): string
    {
        return "yandex_reviews_user_{$userId}_" . md5($url);
    }
}
