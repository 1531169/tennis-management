<?php

class Utils_Authentication_Service
{

    private static $authentication = null;

    public static function isAuthenticated()
    {
        self::setAuthentication(new Zend_Session_Namespace('Authentication'));
        if (! isset(self::$authentication->id) || ! isset(self::$authentication->username) || ! isset(self::$authentication->time)) {
            // nicht authentifiziert
            // TODO: erweitern bzw. genauer machen!
            return false;
        }
        return true;
    }
	
	public static function redirectIfNotAuthenticated($controller = "login", $view = "index")
	{
		if (!self::isAuthenticated()) {
			$redirector = Zend_Controller_Action_HelperBroker::getStaticHelper('redirector');
			return $redirector->gotoSimple("index", "login", null, array());
        }
	}

    public static function login($user = null)
    {
        if ($user == null) {
            throw new Exception('No user was given.');
        }
        $authentication						= new Zend_Session_Namespace('Authentication');
        $authentication->id				= hash('sha256', $user->user_id);
        $authentication->username	= $user->username;
        $authentication->time 			= time();
        $authentication->role				= $user->role;
        $authentication->state			= $user->state;
        self::setAuthentication($authentication);
    }

    public static function logout()
    {
        Zend_Session::namespaceUnset('Authentication');
        //Zend_Session::destroy(true);
        self::setAuthentication(NULL);
    }

    public static function setAuthentication($auth)
    {
        self::$authentication = $auth;
    }

    public static function getAuthentication()
    {
        return self::$authentication;
    }
    
    public static function getInfo($field)
    {
        return self::$authentication->$field;
    }
}
?>