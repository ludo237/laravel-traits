<?php

namespace Ludo237\EloquentTraits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

/**
 * Trait HasUuid
 *
 * @method static self|Builder whereUuid(string $uuid)
 * @method static self|Builder orWhereUuid(string $uuid)
 * @package Ludo237\EloquentTraits
 */
trait HasUuid
{
    /**
     * Defines the UUID field for the model.
     *
     * @return string
     */
    public static function uuidField() : string
    {
        return "uuid";
    }
    
    /**
     * Automatically boot this trait thanks to eloquent
     *
     * @see \Illuminate\Database\Eloquent\Model::bootTraits()
     */
    public static function bootHasUuid() : void
    {
        static::creating(function (Model $model) {
            $model->{self::uuidField()} = Uuid::uuid4()->toString();
        });
    }
    
    /**
     * Get only the first chunk of the UUID, useful for another layer
     * of masking. NOT SUITABLE FOR FETCHING DATA.
     * You should use this only to display a short version of the UUID
     *
     * @return string
     */
    public function getShortUuidAttribute() : string
    {
        $uuidPieces = explode("-", $this->uuid);
        
        return end($uuidPieces);
    }
    
    /**
     * Simple query scope to filter a model by the given uuid
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @param string $uuid
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWhereUuid(Builder $builder, string $uuid) : Builder
    {
        return $builder->where(self::uuidField(), "=", $uuid);
    }

    /**
     * Simple query scope to filter a model by the given uuid
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @param string $uuid
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOrWhereUuid(Builder $builder, string $uuid) : Builder
    {
        return $builder->orWhere(self::uuidField(), "=", $uuid);
    }
}
