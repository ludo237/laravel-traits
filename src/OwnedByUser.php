<?php

namespace Ludo237\EloquentTraits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model as User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

/**
 * Trait OwnedByUser
 *
 * @method static self|Builder ofUserId(int $userId, string $column = "user_id")
 * @method static self|Builder ofUser($user)
 * @method static self|Builder ofAuthenticatedUser()
 * @package Ludo237\EloquentTraits
 */
trait OwnedByUser
{
    /**
     * Defines the class of the owner, we need this for the owner function below
     *
     * @return string
     * @see \Ludo237\EloquentTraits\OwnedByUser::owner()
     */
    abstract protected function ownerClass() : string;
    
    /**
     * Defines the original field of the owner, usually it's the ID
     *
     * @return string
     */
    protected static function ownerField() : string
    {
        return "id";
    }
    
    /**
     * Defines the foreignOwnerField field for the model.
     *
     * @return string
     */
    protected static function foreignOwnerField() : string
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
     * Filter models by the given User id
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @param int $userId
     * @param string $column
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfUserId(Builder $builder, int $userId, string $column = "user_id") : Builder
    {
        return $builder->where($column, "=", $userId);
    }
    
    /**
     * Filter models by the given User model
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @param User $user
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfUser(Builder $builder, $user) : Builder
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
     * @param User $user
     */
    public function setUserAttribute(User $user)
    {
        $this->attributes[self::foreignOwnerField()] = $user->getKey();
        $this->setRelation("user", $user);
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner() : BelongsTo
    {
        return $this->belongsTo(self::ownerClass(), self::foreignOwnerField(), self::ownerField());
    }
    
    /**
     * A Device belongs to an User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user() : BelongsTo
    {
        return $this->owner();
    }
}
