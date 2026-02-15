<?php

namespace App\Http\Requests\Settings;

use Illuminate\Foundation\Http\FormRequest;

class UpdateYandexSettingsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'org_url' => 'required|url',
        ];
    }
    public function messages(): array
    {
        return [
            'org_url.required' => __('settings.yandex.org_url_required'),
            'org_url.url' => __('settings.yandex.org_url_url'),
        ];
    }
}
