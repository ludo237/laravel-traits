<?php

namespace Ludo237\Traits;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait OwnedByUser
{
    /**
     * Defines the class of the owner
     *
     * @return string
     * @example return App\User::class
     * @see \Ludo237\Traits\OwnedByUser::owner()
     */
    abstract public function ownerClass() : string;
    
    /**
     * Defines the original field of the owner
     * usually it's the primary key "id"
     *
     * @return string
     */
    public static function ownerField() : string
    {
        return "id";
    }
    
    /**
     * Defines the foreign key field for the model.
     *
     * @return string
     */
    public static function foreignOwnerField() : string
    {
        return "user_id";
    }
    
    /**
     * @return bool
     */
    public function isOwned() : bool
    {
        return !is_null($this->getAttributeValue(self::foreignOwnerField()));
    }
    
    /**
     * @return bool
     */
    public function isNotOwned() : bool
    {
        return !$this->isOwned();
    }
    
    /**
     * @param \Illuminate\Database\Eloquent\Model $user
     *
     * @return bool
     */
    public function isOwnedBy(Model $user) : bool
    {
        return $this->getAttributeValue(self::foreignOwnerField()) === $user->getKey();
    }
    
    /**
     * @param \Illuminate\Database\Eloquent\Model $user
     *
     * @return bool
     */
    public function isNotOwnedBy(Model $user) : bool
    {
        return !$this->isOwnedBy($user);
    }
    
    /**
     * @param $userId
     *
     * @return bool
     */
    public function isOwnedByUserId($userId) : bool
    {
        return $this->getAttributeValue(self::foreignOwnerField()) == $userId;
    }
    
    /**
     * @param $userId
     *
     * @return bool
     */
    public function isNotOwnedByUserId($userId) : bool
    {
        return !$this->isOwnedByUserId($userId);
    }
    
    /**
     * Set the attribute owner
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
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
    
    /**
     * Return the current owner of the model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user() : BelongsTo
    {
        // TODO this should not be allowed because it's abstract...
        return $this->belongsTo(self::ownerClass(), self::foreignOwnerField(), self::ownerField());
    }
}
