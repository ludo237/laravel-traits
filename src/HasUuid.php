<?php

namespace Ludo237\EloquentTraits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

/**
 * Trait HasUuid
 *
 * @method static self|Builder whereUuid(string $uuid)
 * @package Ludo237\EloquentTraits
 */
trait HasUuid
{
    /**
     * Defines the UUID field for the model.
     *
     * @return string
     */
    protected static function uuidField() : string
    {
        return "uuid";
    }
    
    /**
     * Automatically boot this trait thanks to eloquent
     *
     * @see \Illuminate\Database\Eloquent\Model::bootTraits()
     */
    protected static function bootHasUuid() : void
    {
        static::creating(function (Model $model) {
            $model->{self::uuidField()} = Uuid::uuid4()->toString();
        });
    }
    
    /**
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
}
