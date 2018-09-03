<?php

class ProfilController extends Zend_Controller_Action
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
        // action body
    }


}

