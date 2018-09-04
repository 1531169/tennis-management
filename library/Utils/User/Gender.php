<?php

/**
 *
 * @author Cedric Reinhard
 *
 */
class Utils_User_Gender
{
    const MALE   = "m"; // m = male
    const FEMALE = "f"; // f = female
    const OTHER  = "-";
    
    private static $male   = "Männlich";
    private static $female = "Weiblich";
    private static $other  = "Andere";
    
    public static function toString($role) {
        switch ($role) {
            case self::MALE:
                return utf8_encode(self::$male);
                break;
            case self::FEMALE:
                return utf8_encode(self::$female);
                break;
            case self::OTHER:
                return utf8_encode(self::$other);
                break;
            default:
                return utf8_encode(self::$other);
        }
    }
    
    public static function getDropdownOptionsArray() {
        return array(
            self::MALE   => utf8_encode(self::$male),
            self::FEMALE => utf8_encode(self::$female),
            self::OTHER  => utf8_encode(self::$other)
        );
    }
}