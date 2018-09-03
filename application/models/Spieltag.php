<?php
/**
 *
 * @author Cedric Reinhard
 *        
 */
class Application_Model_Spieltag
{
    protected $_spieltag_id;
    
    protected $_spielplan_id;
    
    protected $_spieldatum;
    
    protected $_team1;
    
    protected $_team2;
    
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
    
    /**
     * @return mixed
     */
    public function getSpieltag_id()
    {
        return $this->_spieltag_id;
    }

    /**
     * @param mixed $_spieltag_id
     */
    public function setSpieltag_id($_spieltag_id)
    {
        $this->_spieltag_id = (int) $_spieltag_id;
    }

    /**
     * @return mixed
     */
    public function getSpielplan_id()
    {
        return $this->_spielplan_id;
    }

    /**
     * @param mixed $_spielplan_id
     */
    public function setSpielplan_id($_spielplan_id)
    {
        $this->_spielplan_id = (int) $_spielplan_id;
    }

    /**
     * @return mixed
     */
    public function getSpieldatum()
    {
        return $this->_spieldatum;
    }
    
    public function getSpieldatumInUS()
    {
        $d = explode(".", $this->_spieldatum);
        return sprintf("%04d-%02d-%02d", $d[2], $d[1], $d[0]);
    }

    /**
     * @param mixed $_spieldatum
     */
    public function setSpieldatum($_spieldatum)
    {
        $this->_spieldatum = $_spieldatum;
    }

    /**
     * @return mixed
     */
    public function getTeam1()
    {
        return $this->_team1;
    }

    /**
     * @param mixed $_team1
     */
    public function setTeam1($_team1)
    {
        $this->_team1 = (string) $_team1;
    }

    /**
     * @return mixed
     */
    public function getTeam2()
    {
        return $this->_team2;
    }

    /**
     * @param mixed $_team2
     */
    public function setTeam2($_team2)
    {
        $this->_team2 = (string) $_team2;
    }
}
