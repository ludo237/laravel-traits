<?php

namespace Ludo237\Traits\Tests\Stubs;

use Illuminate\Auth\Authenticatable as AuthenticatableTrait;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Ludo237\Traits\Bannable;
use Ludo237\Traits\CanBeActivate;
use Ludo237\Traits\ExposeTableProperties;
use Ludo237\Traits\HasSlug;
use Ludo237\Traits\InteractsWithApi;

class UserStub extends Model implements Authenticatable
{
    use AuthenticatableTrait, Bannable, CanBeActivate, ExposeTableProperties, HasSlug, HasUuids, InteractsWithApi;

    protected $table = 'users';

    protected $guarded = ['id'];

    public function uniqueIds(): array
    {
        return ['uuid'];
    }
}
