<?php

namespace Ludo237\EloquentTraits\Tests\Stubs;

use Illuminate\Database\Eloquent\Model;
use Ludo237\EloquentTraits\Bannable;
use Ludo237\EloquentTraits\ExposeTableProperties;
use Ludo237\EloquentTraits\HasSlug;
use Ludo237\EloquentTraits\HasUuid;
use Ludo237\EloquentTraits\InteractsWithApi;

/**
 * Class User
 * @package Ludo237\EloquentTraits\Tests\Stubs
 */
class User extends Model
{
    use Bannable, ExposeTableProperties, InteractsWithApi, HasSlug, HasUuid;
    
    protected $fillable = ["name", "slug", "api_key", "banned_at", "uuid"];
}