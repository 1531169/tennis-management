<?php

class ControllerTestCase extends Zend_Test_PHPUnit_ControllerTestCase
{
    /**
     * @var Zend_Application
     */
    protected $application;

    public function setUp()
    {
        // for the execution timer, this is not in bootstrap as only the controller tests need it
        defined('TIMER_START') || define('TIMER_START', microtime(true));
		$config = new Zend_Config_Ini(APPLICATION_PATH . '/configs/application.ini', 'development');
		Zend_Registry::set('config', $config);
		$this->application = new Zend_Application(APPLICATION_ENV, $config);
		
		$this->bootstrap = $this->application->getBootstrap();
		
		// needed to use database because will not be created automatically in PHPUnit
		//DB config
		$db = Zend_Db::factory($config->resources->db);
		$db->query("SET CHARACTER SET 'utf8'");
		$db->query("SET NAMES 'utf8'");
		Zend_Registry::set("db", $db);
		Zend_Db_Table::setDefaultAdapter($db);
		
        #$this->bootstrap = new Zend_Application(APPLICATION_ENV, APPLICATION_PATH . '/configs/application.ini');
		parent::setUp();
		/*
         * to resolve a bug in Zend_Test_PHPUnit -> will display, that no module is found!
         */
        $this->application->getBootstrap()->getPluginResource('frontcontroller')->init();
		
		# anwendung starten => if remove, not able to go directly on maybe "profile/index"
		$this->dispatch("/");
    }

    public function tearDown()
    {
        // reset some resources
        $this->resetRequest()->resetResponse();
        $this->request->setPost(array());
        $this->request->setQuery(array());
    }
}