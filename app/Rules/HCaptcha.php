<?php

namespace App\Rules;

use GuzzleHttp\Client;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Log;

class HCaptcha implements Rule
{
    private $client;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->client = new Client();
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        // If we are in testing environment we always return true
        if (config('app.env') === 'testing') return true;

        try {
            $response = $this->client->post('https://hcaptcha.com/siteverify', [
                'form_params' => [
                    'secret' => config('services.hcaptcha.secret'),
                    'response' => $value
                ]
            ]);

            return json_decode($response->getBody(), true, 512, JSON_THROW_ON_ERROR)['success'];
        } catch (\Exception $e) {
            Log::error($e);

            return false;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return trans('validation.captcha');
    }
}
