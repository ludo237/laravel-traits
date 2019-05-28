<?php

namespace Ludo237\EloquentTraits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * Trait InteractsWithApi
 * @package Ludo237\EloquentTraits
 */
trait InteractsWithApi
{
    /**
     * Defines the Api field for the model.
     *
     * @return string
     */
    protected static function apiField() : string
    {
        return "api_key";
    }
    
    /**
     * Automagically boot this trait thanks to eloquent
     *
     * @see \Illuminate\Database\Eloquent\Model::bootTraits()
     */
    protected static function bootInteractsWithApi() : void
    {
        static::created(function (Model $model) {
            $model->update([
                self::apiField() => Str::random(20),
            ]);
        });
    }
    
    /**
     * Save the api key in a secure way inside the application
     *
     * @param string $value
     */
    public function setApiKeyAttribute(string $value) : void
    {
        $this->attributes[self::apiField()] = encrypt($value);
    }
    
    /**
     * @return string
     */
    public function getApiKeyAttribute() : string
    {
        return decrypt($this->attributes[self::apiField()]);
    }
    
    /**
     * @param string $apiKey
     *
     * @return bool
     */
    public function hasApiKey(string $apiKey) : bool
    {
        return $this->{self::apiField()} === $apiKey;
    }
    
    /**
     * @param string $apiKey
     *
     * @return bool
     */
    public function doesNotHaveApiKey(string $apiKey) : bool
    {
        return $this->{self::apiField()} !== $apiKey;
    }
}
