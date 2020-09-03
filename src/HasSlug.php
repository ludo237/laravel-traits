<?php

namespace Ludo237\EloquentTraits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * Trait HasSlug
 * @method static self|Builder whereSlug(string $slug)
 * @package Ludo237\EloquentTraits
 */
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
        $slug = Str::slug("{$value} ${randomSalt}", self::separator());
        
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
    
    /**
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @param string $slug
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWhereSlug(Builder $builder, string $slug) : Builder
    {
        return $builder->where(self::slugKey(), "=", $slug);
    }
}
