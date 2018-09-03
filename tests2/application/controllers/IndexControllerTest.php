<?php

require_once realpath(dirname(__FILE__) . '/../ControllerTestCase.php');

/**
 * @group Controllers
 */
class IndexControllerTest extends ControllerTestCase
{
	
    public function test_is_login_page()
    {
		$this->request->setMethod('POST');
        $this->request->setPost(array(
            'username'	=> "c.reinhard",
            'password'		=> "fisch",
            'submit'			=> "Login"
        ));
		
		$this->dispatch("/login/index");
		$controller = new LoginController(
            $this->request,
            $this->response,
            $this->request->getParams()
        );
		$controller->indexAction();
		$this->assertTrue(Utils_Authentication_Service::isAuthenticated());
		$this->assertController('login');
		$this->assertAction('index');
		$this->assertResponseCode(302);
		$this->assertRedirectTo('/index', "redirected");
		print_r($_SESSION);
		
		print_r($this->getRequest());
		print_r($this->getResponse());
		
		$this->dispatch("/index");
		$controller = new IndexController(
            $this->request,
            $this->response,
            $this->request->getParams()
        );
		$controller->indexAction();
		
		$this->assertController('index');
        $this->assertAction('index');
		
        #$this->assertRedirectTo('index', "rediceted");
        $this->resetRequest()->resetResponse();
    }
	
	public function test_login()
    {
        $this->request->setMethod('POST');
        $this->request->setPost(
			array(
				'username'	=> 'c.reinhard',
				'password'		=> 'fisch',
				'submit'			=> 'Anmelden'
			)
		);
		
		$this->dispatch("/");
		
		$controller = new IndexController(
            $this->request,
            $this->response,
            $this->request->getParams()
        );
		
        $this->dispatch("/login");
        $this->assertController('login');
        $this->assertAction('index');
       # $this->assertResponseCode(200);
    }
}