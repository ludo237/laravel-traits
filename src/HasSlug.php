<?php

namespace Ludo237\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

trait HasSlug
{
    /**
     * Database column name used to create the slug
     *
     * @return string
     */
    public static function sluggableKey() : string
    {
        return "name";
    }
    
    /**
     * Separator for multi words slug
     *
     * @return string
     */
    public static function separator() : string
    {
        return ".";
    }
    
    /**
     * Database column name used to store the slug value
     *
     * @return string
     */
    public static function slugKey() : string
    {
        return "slug";
    }
    
    /**
     * A Wrapper for generate a slug of a given model
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     *
     * @return void
     */
    private static function generateSlug(Model $model) : void
    {
        $value = $model->getAttributeValue(self::sluggableKey());
        $randomSalt = Str::random(8);
        $slug = Str::slug("$value $randomSalt", self::separator());
        
        $model->setAttribute(self::slugKey(), $slug);
    }
    
    /**
     * Automatically inject the slug creation during the model creation/update if not provided
     *
     * @return void
     */
    public static function bootHasSlug() : void
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
