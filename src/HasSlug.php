<?php

namespace Ludo237\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

trait HasSlug
{
    /**
     * Database column name used to create the slug
     */
    public static function sluggableKey(): string
    {
        return 'name';
    }

    /**
     * Separator for multi words slug
     */
    public static function separator(): string
    {
        return '.';
    }

    /**
     * Database column name used to store the slug value
     */
    public static function slugKey(): string
    {
        return 'slug';
    }

    private static function generateSlug(Model $model): void
    {
        $value = $model->getAttributeValue(self::sluggableKey());
        $randomSalt = Str::random(8);
        $slug = Str::slug("$value $randomSalt", self::separator());

        $model->setAttribute(self::slugKey(), $slug);
    }

    public static function bootHasSlug(): void
    {
        static::creating(function (Model $model) {
            if (empty($model->getAttributeValue(self::slugKey()))) {
                self::generateSlug($model);
            }
        });

        static::updating(function (Model $model) {
            if (empty($model->getAttributeValue(self::slugKey()))) {
                self::generateSlug($model);
            }
        });
    }
}
