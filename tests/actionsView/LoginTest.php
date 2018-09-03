<?php

class LoginTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    
    protected $phpUnit;
    
    public function _before()
    {
        $this->phpUnit = new PHPUnitBaseTestCase($this->getModule('ZF1')->bootstrap);
    }
    
    public function _after()
    {
        unset($this->phpUnit);
    }
    
    public function testBootstrapIsAvailable()
    {
        $this->tester->assertTrue($this->phpUnit instanceof PHPUnitBaseTestCase, "Bla schwall");
        
        $e = new stdClass();
        $e->type = Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_CONTROLLER;
        $e->exception = new Zend_Controller_Exception('Invalid controller');
        
        $this->phpUnit->request->setParam('error_handler', $e);
        $this->phpUnit->request->setParam('displayExceptions', true);
        $this->phpUnit->request->setParam('controller', 'error');
        $this->phpUnit->request->setParam('action', 'error');
        
        $this->phpUnit->dispatch("/error/error");
        
        $controller = new ErrorController(
            $this->phpUnit->request,
            $this->phpUnit->response,
            $this->phpUnit->request->getParams()
            );
        
        $controller->errorAction();
        
        if($controller->view->exception) {
            $isInstanceOf = $controller->view->exception instanceof Zend_Controller_Exception;
            $this->phpUnit->assertTrue($isInstanceOf, "Test: " . ($isInstanceOf ? "true" : "false"));
        } else {
            $this->phpUnit->assertTrue($controller->view->test == "Daaa", "Inhalt: " . $controller->view->test);
            $this->tester->comment("irgendwas");
            #$this->phpUnit->fail("The exception wasn't set!: " . $controller->view->test);
        }
    }
    
    public function testIndexActionError()
    {
        $request = $this->phpUnit->getRequest();
        $request->setMethod('POST');
        $request->setPost(array(
            'username' => "c.reinhard",
            'password' => "fisch",
            'submit'   => "Login"
        ));
        $this->phpUnit->dispatch('/login');
        $this->phpUnit->assertRedirectTo('/index', "rediceted");
        $this->phpUnit->resetRequest()->resetResponse();
    }
}