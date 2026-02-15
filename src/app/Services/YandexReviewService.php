<?php

namespace App\Services;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use App\Models\YandexSetting;

class YandexReviewService
{
    protected YandexReviewParser $parser;
    protected YandexReviewCache $cache;

    public function __construct(YandexReviewParser $parser, YandexReviewCache $cache)
    {
        $this->parser = $parser;
        $this->cache = $cache;
    }

    /**
     * Получает отзывы компании по ссылке в настройках пользователя.
     *
     * @param int $userId
     * @return array
     * @throws ConnectionException
     */
    public function getReviewsForUser(int $userId): array
    {
        $setting = YandexSetting::where('user_id', $userId)->first();

        if (!$setting || empty(trim($setting->org_url))) {
            return ['error' => 'Яндекс.Ссылка не найдена, перейдите в настройки и установите ссылку'];
        }

        $cacheKey = $this->cache->makeKey($userId, $setting->org_url);

        return $this->cache->remember($cacheKey, function() use ($setting) {
            $response = Http::withHeaders([
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 Chrome/91.0.4472.124 Safari/537.36',
            ])->get($setting->org_url);

            if ($response->failed()) {
                return ['error' => 'Не удалось получить отзывы. Проверьте ссылку в настройках'];
            }

            return $this->parser->parse($response->body());
        });
    }
}
