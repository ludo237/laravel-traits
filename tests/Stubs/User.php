<?php

namespace Ludo237\EloquentTraits\Tests\Stubs;

use Illuminate\Auth\Authenticatable as AuthenticatableTrait;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Ludo237\EloquentTraits\Bannable;
use Ludo237\EloquentTraits\CanBeActivate;
use Ludo237\EloquentTraits\ExposeTableProperties;
use Ludo237\EloquentTraits\HasSlug;
use Ludo237\EloquentTraits\HasUuid;
use Ludo237\EloquentTraits\InteractsWithApi;

/**
 * Class User
 * @package Ludo237\EloquentTraits\Tests\Stubs
 */
class User extends Model implements Authenticatable
{
    use AuthenticatableTrait, CanBeActivate, Bannable, ExposeTableProperties, InteractsWithApi, HasSlug, HasUuid;
    
    protected $fillable = ["name", "slug", "api_key", "banned_at", "activated_at", "uuid"];
}
