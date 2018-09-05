<?php

class UseroverviewController extends Zend_Controller_Action
{

    protected $_role;

    public function init()
    {
        Utils_Authentication_Service::redirectIfNotAuthenticated();
		
		$this->_role = Utils_Authentication_Service::getInfo('role');
        $this->view->role = $this->_role;
		
        // TODO: muss in jedem Controller implementiert werden!
        $this->checkAccess();
    }

    public function checkAccess()
    {
        if ($this->_role == Utils_User_Role::PLAYER || $this->_role == Utils_User_Role::COACH) {
            $this->redirect('index');
        }
    }

    public function indexAction()
    {
        $usermapper = new Application_Model_UserMapper();
        $this->view->users = $usermapper->fetchAll();
    }
    
    public function viewAction()
    {
        $request = $this->getRequest();
        $user_id = $request->getParam('userid');
        $user    = new Application_Model_User();
        $mapper  = new Application_Model_Usermapper();
        $mapper->find($user_id, $user);
        $this->view->user = $user;
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

    public function editAction()
    {
        $request = $this->getRequest();
        $user_id = $request->getParam('userid');
        $user    = new Application_Model_User();
        $mapper  = new Application_Model_Usermapper();
        $mapper->find($user_id, $user);
        $form = new Application_Form_EditUser($user);
        $form->setAction('edit');
        if ($request->isPost()) {
            if ($form->isValid($request->getPost())) {
                $user = new Application_Model_User($form->getValues());
                $mapper->update($user);
                return $this->_helper->redirector('index');
            }
        }
        $this->view->form = $form;
    }

    public function deleteAction()
    {
        $request = $this->getRequest();
        $user_id = $request->getParam('userid');
        $user = new Application_Model_User();
        $mapper = new Application_Model_Usermapper();
        $mapper->find($user_id, $user);
        $this->view->user = $user;
        echo $user->getUsername();
    }
}

