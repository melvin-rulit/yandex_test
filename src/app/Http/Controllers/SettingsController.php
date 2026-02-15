<?php

namespace App\Http\Controllers;

use App\Http\Requests\Settings\StoreYandexSettingsRequest;
use App\Http\Resources\YandexSettingResource;
use App\Models\YandexSetting;
use App\Services\YandexReviewCache;
use App\Services\YandexReviewService;
use Illuminate\Http\JsonResponse;

class SettingsController extends Controller
{
    public function __construct(protected YandexReviewService $yandexService){}

    public function settings(): JsonResponse
    {
        $user = auth()->user();
        $settings = $user->yandexSetting;

        return $settings
            ? (new YandexSettingResource($settings))->response()->setStatusCode(200)
            : response()->json(['data' => null], 200);
    }
    public function store(StoreYandexSettingsRequest $request, YandexReviewCache $cache)
    {
        $setting = YandexSetting::updateOrCreate(
            ['user_id' => auth()->id()],
            ['org_url' => $request->org_url]
        );

        $cacheKey = $cache->makeKey(auth()->id(), $request->org_url);
        $cache->forget($cacheKey);

        return (new YandexSettingResource($setting))
            ->response()
            ->setStatusCode(200);
    }
}
