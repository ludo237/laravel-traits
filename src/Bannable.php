<?php

namespace Ludo237\Traits;

use Carbon\Carbon;
use Illuminate\Support\Facades\Date;

trait Bannable
{
    /**
     * Defines the ban field for the model.
     * You can overwrite this field
     *
     * @return string
     */
    public static function banField() : string
    {
        return "banned_at";
    }
    
    /**
     * Get the total days remains for the ban
     *
     * @return int
     */
    public function remainingBanDays() : int
    {
        return Date::today()->diffInDays(
            $this->getAttributeValue(self::banField())
        );
    }
    
    /**
     * Check if the entity is currently banned
     *
     * @return bool
     */
    public function isBanned() : bool
    {
        return !is_null(
            $this->getAttributeValue(self::banField())
        );
    }
    
    /**
     * Return the opposite of isBanned
     *
     * @return bool
     * @see \Ludo237\Traits\Bannable::isBanned()
     */
    public function isNotBanned() : bool
    {
        return !$this->isBanned();
    }
    
    /**
     * Check if the current entity is still banned
     *
     * @return bool
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
     *
     * @return bool
     */
    public function hasExpiredBan() : bool
    {
        return Date::today()->greaterThan(
            $this->getAttributeValue(self::banField())
        );
    }
    
    /**
     * Ban an entity with a given date
     *
     * @param \Carbon\Carbon $banDate
     */
    public function banFor(Carbon $banDate) : void
    {
        $this->update([
            self::banField() => $banDate,
        ]);
    }
    
    /**
     * Ban an user for one day
     *
     * @return void
     */
    public function banForOneDay() : void
    {
        $this->banFor(Date::tomorrow());
    }
    
    /**
     * Ban an user for one week
     *
     * @return void
     */
    public function banForOneWeek() : void
    {
        $this->banFor(Date::today()->addWeek());
    }
    
    /**
     * Ban an user for one month
     *
     * @return void
     */
    public function banForOneMonth() : void
    {
        $this->banFor(Date::today()->addMonth());
    }
    
    /**
     * Ban an user for one year
     *
     * @return void
     */
    public function banForOneYear() : void
    {
        $this->banFor(Date::today()->addYear());
    }
    
    /**
     * Ban an user for one century,
     * this should be interpreted as forever
     *
     * @return void
     */
    public function banForever() : void
    {
        $this->banFor(Date::today()->addCentury());
    }
    
    /**
     * Lift the ban from the entity
     *
     * @return void
     */
    public function liftBan() : void
    {
        $this->update([
            self::banField() => null,
        ]);
    }
}
