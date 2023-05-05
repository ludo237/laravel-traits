<?php

namespace Ludo237\Traits;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait OwnedByUser
{
    /**
     * Defines the class of the owner
     */
    abstract public function ownerClass() : string;
    
    /**
     * Defines the original field of the owner
     * usually it's the primary key "id"
     */
    public static function ownerField() : string
    {
        return "id";
    }
    
    /**
     * Defines the foreign key field for the model.
     */
    public static function foreignOwnerField() : string
    {
        return "user_id";
    }
    
    public function isOwned() : bool
    {
        return !is_null($this->getAttributeValue(self::foreignOwnerField()));
    }
    
    public function isNotOwned() : bool
    {
        return !$this->isOwned();
    }
    
    public function isOwnedBy(Model $user) : bool
    {
        return $this->getAttributeValue(self::foreignOwnerField()) === $user->getKey();
    }
    
    public function isNotOwnedBy(Model $user) : bool
    {
        return !$this->isOwnedBy($user);
    }
    
    public function isOwnedByUserId($userId) : bool
    {
        return $this->getAttributeValue(self::foreignOwnerField()) == $userId;
    }
    
    public function isNotOwnedByUserId($userId) : bool
    {
        return !$this->isOwnedByUserId($userId);
    }
    
    public function owner() : Attribute
    {
        return Attribute::make(
            get: fn($value) => $value,
            set: function (Model $value, array $attributes) {
                $attributes[self::foreignOwnerField()] = $value->getKey();
                $this->setRelation("user", $value);
                
                return $attributes;
            }
        );
    }
    
    public function user() : BelongsTo
    {
        // TODO this should not be allowed because it's abstract...
        return $this->belongsTo(self::ownerClass(), self::foreignOwnerField(), self::ownerField());
    }
}
