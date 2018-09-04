<?php

/** 
 * Contains the existing roles of the users.
 * 
 * @author Cedric Reinhard
 * 
 */
class Utils_User_Role
{
    const ADMIN  = 'admin';
    const COACH  = 'coach';
    const PLAYER = 'player';
    
    private static $admin  = "Admin";
    private static $coach  = "Coach";
    private static $player = "Spieler";
    
    public static function toString($role) {
        switch ($role) {
            case self::ADMIN:
                return self::$admin;
                break;
            case self::COACH:
                return self::$coach;
                break;
            default:
                // every other situation => player
                return self::$player;
        }
    }
    
    public static function getDropdownOptionsArray() {
        return array(
            self::ADMIN  => self::$admin,
            self::COACH  => self::$coach,
            self::PLAYER => self::$player
        );
    }
}

