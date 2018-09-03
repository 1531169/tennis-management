<?php
/**
 *
 * @author Cedric Reinhard
 *        
 */
class Application_Model_Spielplan
{
    protected $_spielplan_id;
    
    protected $_saison;
    
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
    public function getSaison()
    {
        return $this->_saison;
    }

    /**
     * @param mixed $_saison
     */
    public function setSaison($_saison)
    {
        $this->_saison = (string) $_saison;
    }
}
