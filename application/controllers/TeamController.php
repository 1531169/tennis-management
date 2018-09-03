<?php

class TeamController extends Zend_Controller_Action
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
        $usermapper = new Application_Model_UserMapper();
        $this->view->users = $usermapper->fetchAllFromTeam();
    }

    public function addAction()
    {
        $request = $this->getRequest();
        $form = new Application_Form_AddUser();
        $form->setAction('add');
        if ($request->isPost()) {
            if ($form->isValid($request->getPost())) {
                $user = new Application_Model_User($form->getValues());
                $mapper = new Application_Model_UserMapper();
                $mapper->save($user);
                return $this->_helper->redirector('index');
            }
        }
        
        $this->view->form = $form;
    }
}



