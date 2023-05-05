<?php

namespace Ludo237\Traits;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

trait HasUuid
{
    /**
     * Defines the UUID field for the model.
     */
    public static function uuidField() : string
    {
        return "uuid";
    }
    
    /**
     * Automatically boot this trait thanks to eloquent
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
     */
    public function shortUuid() : Attribute
    {
        $uuid = $this->getAttributeValue(self::uuidField());
        
        return Attribute::make(
            get: fn() => substr($uuid, strrpos($uuid, "-") + 1)
        );
    }
}
