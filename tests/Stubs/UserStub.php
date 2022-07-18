<?php

namespace Ludo237\Traits\Tests\Stubs;

use Illuminate\Auth\Authenticatable as AuthenticatableTrait;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Ludo237\Traits\Bannable;
use Ludo237\Traits\CanBeActivate;
use Ludo237\Traits\ExposeTableProperties;
use Ludo237\Traits\HasSlug;
use Ludo237\Traits\HasUuid;
use Ludo237\Traits\InteractsWithApi;

class UserStub extends Model implements Authenticatable
{
    use AuthenticatableTrait, CanBeActivate, Bannable, ExposeTableProperties, InteractsWithApi, HasSlug, HasUuid;
    
    protected $table = "users";
    
    protected $guarded = ["id"];
}
