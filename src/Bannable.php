<?php

namespace Ludo237\Traits;

use Carbon\Carbon;
use Illuminate\Support\Facades\Date;

trait Bannable
{
    /**
     * Defines the ban field for the model.
     * You can overwrite this field
     */
    public static function banField() : string
    {
        return "banned_at";
    }
    
    public function remainingBanDays() : int
    {
        return Date::today()->diffInDays(
            $this->getAttributeValue(self::banField())
        );
    }
    
    public function isBanned() : bool
    {
        return !is_null(
            $this->getAttributeValue(self::banField())
        );
    }
    
    public function isNotBanned() : bool
    {
        return !$this->isBanned();
    }
    
    /**
     * Check if the current entity is still banned
     */
    public function isStillBanned() : bool
    {
        return Date::today()->lessThanOrEqualTo(
            $this->getAttributeValue(self::banField())
        );
    }
    
    /**
     * Determine if the entity has an expired ban
     * this is useful because we can lift it and remove the ban
     */
    public function hasExpiredBan() : bool
    {
        return Date::today()->greaterThan(
            $this->getAttributeValue(self::banField())
        );
    }
    
    public function banFor(Carbon $banDate) : void
    {
        $this->update([
            self::banField() => $banDate,
        ]);
    }
    
    public function banForOneDay() : void
    {
        $this->banFor(Date::tomorrow());
    }
    
    public function banForOneWeek() : void
    {
        $this->banFor(Date::today()->addWeek());
    }
    
    public function banForOneMonth() : void
    {
        $this->banFor(Date::today()->addMonth());
    }
    
    public function banForOneYear() : void
    {
        $this->banFor(Date::today()->addYear());
    }
    
    /**
     * Ban an user for one century,
     * this should be interpreted as forever
     */
    public function banForever() : void
    {
        $this->banFor(Date::today()->addCentury());
    }
    
    public function liftBan() : void
    {
        $this->update([
            self::banField() => null,
        ]);
    }
}
