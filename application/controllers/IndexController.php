<?php

class IndexController extends Zend_Controller_Action
{
	protected $_role;

    public function init()
    {
        Utils_Authentication_Service::redirectIfNotAuthenticated();
		
		$this->_role = Utils_Authentication_Service::getInfo('role');
        $this->view->role = $this->_role;
    }

    public function indexAction()
    {
        $user = new Application_Model_User();
        $usermapper = new Application_Model_Usermapper();
        $usermapper->find(1, $user);
    }

    public function logoutAction()
    {
        Utils_Authentication_Service::logout();
        $this->redirect('login');
    }
}

