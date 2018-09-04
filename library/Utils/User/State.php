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
    private static $deleted  = "Gel&ouml;scht";
    private static $notDef   = "Undefiniert";
    
    public static function toString($role) {
        switch ($role) {
            case self::ACTIVE:
                return self::$active;
                break;
            case self::INACTIVE:
                return self::$inactive;
                break;
            case self::DISABLED:
                return self::$disabled;
                break;
            case self::DELETED:
                return self::$deleted;
                break;
            default:
                return self::$notDef;
        }
    }
}

