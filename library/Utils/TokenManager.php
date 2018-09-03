<?php
/**
 * This class handles the token for the submit of forms to prevent multiple 
 * excecution of requests.
 *  
 * @author Cedric Reinhard
 * @todo: use in every form to make database more save
 */
class Utils_TokenManager
{
    /**
     * Name of the session variable.
     * @var string
     */
    private static $key = "tokens";
    
    /**
     * Creates a token usable in a form
     * @return string
     */
    public static function getToken()
    {
        $token = sha1(mt_rand());
        if (! isset($_SESSION[self::$key])) {
            $_SESSION[self::$key] = array(
                $token => 1
            );
        } else {
            $_SESSION[self::$key][$token] = 1;
        }
        return $token;
    }
    
    /**
     * Check if a token is valid. Removes it from the valid tokens list
     * @param string $token The token
     * @return bool
     */
    public static function isTokenValid($token)
    {
        if (! empty($_SESSION[self::$key][$token])) {
            unset($_SESSION[self::$key][$token]);
            return true;
        }
        return false;
    }
    
    
    
    
    
    #to prevent multiple requests
    #onsubmit=\"return (typeof submitted == 'undefined') ? (submitted = true) : !submitted\"
    
    
    
}
