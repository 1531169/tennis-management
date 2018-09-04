<?php

/**
 *
 * @author Cedric Reinhard
 *        
 */
class Utils_User_State
{
    const ACTIVE   = "active";
    const INACTIVE = "inactive";
    const DISABLED = "disabled";
    const DELETED  = "deleted";
    
    private static $active   = "Aktiv";
    private static $inactive = "Inaktiv";
    private static $disabled = "Gesperrt";
    private static $deleted  = "Gelöscht";
    private static $notDef   = "Undefiniert";
    
    public static function toString($role) {
        switch ($role) {
            case self::ACTIVE:
                return utf8_encode(self::$active);
                break;
            case self::INACTIVE:
                return utf8_encode(self::$inactive);
                break;
            case self::DISABLED:
                return utf8_encode(self::$disabled);
                break;
            case self::DELETED:
                return utf8_encode(self::$deleted);
                break;
            default:
                return utf8_encode(self::$notDef);
        }
    }
    
    public static function getDropdownOptionsArray() {
        return array(
            self::ACTIVE   => utf8_encode(self::$active),
            self::INACTIVE => utf8_encode(self::$inactive),
            self::DISABLED => utf8_encode(self::$disabled),
            self::DELETED  => utf8_encode(self::$deleted)
        );
    }
}

