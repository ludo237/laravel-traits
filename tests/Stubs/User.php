<?php

namespace Ludo237\EloquentTraits\Tests\Stubs;

use Illuminate\Database\Eloquent\Model;
use Ludo237\EloquentTraits\ExposeTableProperties;
use Ludo237\EloquentTraits\HasSlug;
use Ludo237\EloquentTraits\HasUuid;

/**
 * Class User
 * @package Ludo237\EloquentTraits\Tests\Stubs
 */
class User extends Model
{
    use ExposeTableProperties, HasSlug, HasUuid;
    
    protected $fillable = ["name", "slug", "uuid"];
}