<?php

namespace Ludo237\Traits\Tests\Stubs;

use Illuminate\Database\Eloquent\Model;
use Ludo237\Traits\OwnedByUser;

class PostStub extends Model
{
    use OwnedByUser;
    
    protected $table = "posts";
    
    protected $guarded = ["id"];
    
    protected function ownerClass() : string
    {
        return UserStub::class;
    }
}
