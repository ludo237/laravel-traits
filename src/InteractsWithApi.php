<?php

namespace Ludo237\Traits;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

trait InteractsWithApi
{
    /**
     * Defines the Api field for the model.
     *
     * @return string
     */
    public static function apiField() : string
    {
        return "api_key";
    }
    
    /**
     * Automatically boot this trait thanks to eloquent
     *
     * @see \Illuminate\Database\Eloquent\Model::bootTraits()
     */
    public static function bootInteractsWithApi() : void
    {
        static::created(function (Model $model) {
            $model->update([
                self::apiField() => Str::random(20),
            ]);
        });
    }
    
    /**
     * Accessor and Mutator for API key field
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    public function apiKey() : Attribute
    {
        return Attribute::make(
            get: fn(string $value, array $attributes) => decrypt($attributes[self::apiField()]),
            set: fn(string $value, array $attributes) => $attributes[self::apiField()] = encrypt($value)
        );
    }
    
    /**
     * @param string $apiKey
     *
     * @return bool
     */
    public function hasApiKey(string $apiKey) : bool
    {
        return $this->getAttributeValue(self::apiField()) === $apiKey;
    }
    
    /**
     * @param string $apiKey
     *
     * @return bool
     */
    public function doesNotHaveApiKey(string $apiKey) : bool
    {
        return !$this->hasApiKey($apiKey);
    }
}
