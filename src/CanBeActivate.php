<?php

namespace Ludo237\EloquentTraits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Date;

/**
 * Trait CanBeActivated
 * @method static self|Builder activated()
 * @method static self|Builder notActivated()
 * @package Ludo237\EloquentTraits
 */
trait CanBeActivated
{
    /**
     * Defines the activated at field for the model.
     * You can overwrite this field
     *
     * @return string
     */
    public static function activateAtField() : string
    {
        return "activated_at";
    }

    /**
     * Check if the current model is active
     *
     * @return bool
     */
    public function isActive() : bool
    {
        return !is_null($this->getAttributeValue(self::activateAtField()));
    }

    /**
     * Check if the current model is not active
     *
     * @return bool
     */
    public function isNotActive() : bool
    {
        return !$this->isActive();
    }



    /**
     * Activate a model
     *
     * @return void
     */
    public function activate() : void
    {
        $this->update([
            self::activateAtField() => Date::today(),
        ]);
    }

    /**
     * Deactivate a model
     *
     * @return void
     */
    public function deactivate() : void
    {
        $this->update([
            self::activateAtField() => null,
        ]);
    }

    /**
     * Return only the active entities
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive(Builder $builder) : Builder
    {
        return $builder->whereNotNull(self::activateAtField());
    }

    /**
     * Return only the not active entities
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeNotActive(Builder $builder) : Builder
    {
        return $builder->whereNull(self::activateAtField());
    }
}
