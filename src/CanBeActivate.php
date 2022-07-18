<?php

namespace Ludo237\Traits;

use Illuminate\Support\Facades\Date;

trait CanBeActivate
{
    /**
     * Defines the activated at field for the model.
     * You can overwrite this field
     *
     * @return string
     */
    public static function activateAtField() : string
    {
        return "activated_at";
    }
    
    /**
     * Check if the current model is active
     *
     * @return bool
     */
    public function isActive() : bool
    {
        return !is_null($this->getAttributeValue(self::activateAtField()));
    }
    
    /**
     * Check if the current model is not active
     *
     * @return bool
     */
    public function isNotActive() : bool
    {
        return !$this->isActive();
    }
    
    /**
     * Activate a model
     *
     * @return void
     */
    public function activate() : void
    {
        $this->update([
            self::activateAtField() => Date::today(),
        ]);
    }
    
    /**
     * Deactivate a model
     *
     * @return void
     */
    public function deactivate() : void
    {
        $this->update([
            self::activateAtField() => null,
        ]);
    }
}
