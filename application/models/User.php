<?php

class Application_Model_User
{

    protected $_user_id;

    protected $_state;

    protected $_role;

    protected $_surname;

    protected $_givenname;

    protected $_gender;

    protected $_username;

    protected $_password;
    
    protected $_email;

    protected $_email2;

    protected $_organization;

    public function __construct(array $options = null)
    {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }

    public function __set($name, $value)
    {
        $method = 'set' . $name;
        if (('mapper' == $name) || ! method_exists($this, $method)) {
            throw new Exception('Invalid user property');
        }
        $this->$method($value);
    }

    public function __get($name)
    {
        $method = 'get' . $name;
        if (('mapper' == $name) || ! method_exists($this, $method)) {
            throw new Exception('Invalid user property');
        }
        return $this->$method();
    }

    public function setOptions(array $options)
    {
        $methods = get_class_methods($this);
        foreach ($options as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (in_array($method, $methods)) {
                $this->$method($value);
            }
        }
        return $this;
    }

    public function getUser_id()
    {
        return $this->_user_id;
    }

    public function setUser_id($id)
    {
        $this->_user_id = (int) $id;
        return $this;
    }

    public function getState()
    {
        return $this->_state;
    }

    public function setState($state)
    {
        $this->_state = (string) $state;
        return $this;
    }

    public function getRole()
    {
        return $this->_role;
    }

    public function setRole($role)
    {
        $this->_role = (string) $role;
        return $this;
    }

    public function getSurname()
    {
        return $this->_surname;
    }

    public function setSurname($sn)
    {
        $this->_surname = (string) $sn;
        return $this;
    }

    public function getGivenname()
    {
        return $this->_givenname;
    }

    public function setGivenname($gn)
    {
        $this->_givenname = (string) $gn;
        return $this;
    }

    public function getGender()
    {
        return $this->_gender;
    }

    public function setGender($gender)
    {
        $this->_gender = $gender;
        return $this;
    }

    public function getUsername()
    {
        return $this->_username;
    }
    
    public function setUsername($username)
    {
        $this->_username = $username;
        return $this;
    }

    public function getPassword()
    {
        return $this->_password;
    }

    public function setPassword($pw)
    {
        $this->_password = (string) $pw;
        return $this;
    }
    
    public function getEmail()
    {
        return $this->_email;
    }
    
    public function setEmail($email)
    {
        $this->_email = (string) $email;
        return $this;
    }

    public function getEmail2()
    {
        return $this->_email2;
    }

    public function setEmail2($email2)
    {
        $this->_email2 = (string) $email2;
        return $this;
    }

    public function getOrganization()
    {
        return $this->_organization;
    }

    public function setOrganization($organization)
    {
        $this->_organization = (string) $organization;
        return $this;
    }
}

?>