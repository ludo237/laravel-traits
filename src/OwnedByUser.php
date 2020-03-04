<?php

namespace Ludo237\EloquentTraits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

/**
 * Trait OwnedByUser
 *
 * @method static self|Builder ofUserId($userId, string $column = "user_id")
 * @method static self|Builder ofUser($user)
 * @method static self|Builder ofAuthenticatedUser()
 * @package Ludo237\EloquentTraits
 */
trait OwnedByUser
{
    /**
     * Defines the class of the owner
     *
     * @return string
     * @example return App\User::class
     * @see \Ludo237\EloquentTraits\OwnedByUser::owner()
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
        return !is_null($this->{self::foreignOwnerField()});
    }
    
    /**
     * @return bool
     */
    public function isNotOwned() : bool
    {
        return is_null($this->{self::foreignOwnerField()});
    }
    
    /**
     * @param \Illuminate\Database\Eloquent\Model $user
     *
     * @return bool
     */
    public function isOwnedBy(Model $user) : bool
    {
        return $this->{self::foreignOwnerField()} === $user->getKey();
    }
    
    /**
     * @param $userId
     *
     * @return bool
     */
    public function isOwnedByUserId($userId) : bool
    {
        return $this->{self::foreignOwnerField()} == $userId;
    }
    
    /**
     * Filter models by the given User id
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @param int|string $userId
     * @param string $column
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfUserId(Builder $builder, $userId, string $column = "user_id") : Builder
    {
        return $builder->where($column, "=", $userId);
    }
    
    /**
     * Filter models by the given User model
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @param \Illuminate\Database\Eloquent\Model $user
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfUser(Builder $builder, Model $user) : Builder
    {
        return $this->scopeOfUserId($builder, $user->getKey());
    }
    
    /**
     * Filter models by the current authenticated user
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfAuthenticatedUser(Builder $builder) : Builder
    {
        return $this->scopeOfUserId($builder, Auth::id());
    }
    
    /**
     * Automagically set the user attribute without exposing the key
     *
     * @param \Illuminate\Database\Eloquent\Model $user
     */
    public function setUserAttribute(Model $user)
    {
        $this->attributes[self::foreignOwnerField()] = $user->getKey();
        $this->setRelation("user", $user);
    }
    
    /**
     * Return the current owner of the model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner() : BelongsTo
    {
        return $this->belongsTo(self::ownerClass(), self::foreignOwnerField(), self::ownerField());
    }
    
    /**
     * Return the same result of owner() but with a fancy method name
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user() : BelongsTo
    {
        return $this->owner();
    }
}
