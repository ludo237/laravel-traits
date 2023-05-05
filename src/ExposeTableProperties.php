<?php

namespace Ludo237\Traits;

trait ExposeTableProperties
{
    /**
     * Return the table name of the current eloquent model
     */
    public static function tableName() : string
    {
        return (new self())->getTable();
    }
    
    /**
     * Return the primary key name of the current eloquent model
     */
    public static function primaryKeyName() : string
    {
        return (new self())->getKeyName();
    }
    
    /**
     * Return the primary key type of the current eloquent model
     */
    public static function primaryKeyType() : string
    {
        return (new self())->getKeyType();
    }
    
    /**
     * Get the primary key properties with an array
     */
    public static function primaryKey() : array
    {
        return [
            "name" => self::primaryKeyName(),
            "type" => self::primaryKeyType(),
        ];
    }
}
