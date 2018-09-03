<?php 

/**
 * Base class for writing test in an old zend framework without installing phpunit.
 * This class automatically boostraps the zend application in the background 
 * and test can be written like usually.
 * 
 * @author Cedric
 *
 */
class PHPUnitBaseTestCase extends Zend_Test_PHPUnit_ControllerTestCase
{
    protected $_application;
    
    public function __construct(Zend_Application $zf1)
    {
        $this->setApplication($zf1);
        $this->setUp();
    }
    
    public function setUp()
    {
        parent::setUp();
        /*
         * to resolve a bug in Zend_Test_PHPUnit -> will display, that no module is found!
         */
        $this->_application->getBootstrap()->getPluginResource('frontcontroller')->init();
    }
    
    public function setApplication($application)
    {
        $this->_application = $application;
    }
    
    public function getApplication()
    {
        return $this->_application;
    }
}

?>