<?php

namespace Ludo237\Traits;

use Illuminate\Support\Facades\Date;

trait CanBeActivate
{
    /**
     * Defines the activated at field for the model.
     * You can overwrite this field
     */
    public static function activateAtField() : string
    {
        return "activated_at";
    }
    
    public function isActive() : bool
    {
        return !is_null($this->getAttributeValue(self::activateAtField()));
    }
    
    public function isNotActive() : bool
    {
        return !$this->isActive();
    }
    
    public function activate() : void
    {
        $this->update([
            self::activateAtField() => Date::today(),
        ]);
    }
    
    public function deactivate() : void
    {
        $this->update([
            self::activateAtField() => null,
        ]);
    }
}
