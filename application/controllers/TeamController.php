<?php

class TeamController extends Zend_Controller_Action
{
	protected $_role;

    public function init()
    {
        Utils_Authentication_Service::redirectIfNotAuthenticated();
        
        $this->_role      = Utils_Authentication_Service::getInfo('role');
        $this->view->role = $this->_role;
    }

    public function indexAction()
    {
        $user       = new Application_Model_User();
        $usermapper = new Application_Model_Usermapper();
        $usermapper->findByUsername(Utils_Authentication_Service::getInfo('username'), $user);
        $this->view->users = $usermapper->fetchAllFromTeam($user->getOrganization());
    }
    
    public function viewAction()
    {
        $request   = $this->getRequest();
        $user_id   = $request->getParam('userid');
        $user      = new Application_Model_User();
        $localUser = new Application_Model_User();
        $mapper    = new Application_Model_Usermapper();
        $mapper->findByUsername(Utils_Authentication_Service::getInfo('username'), $localUser);
        $mapper->find($user_id, $user);
        $this->view->user      = $user;
        $this->view->localUser = $localUser;
    }

    public function addAction()
    {
        $request = $this->getRequest();
        $form    = new Application_Form_AddUser();
        $mapper  = new Application_Model_Usermapper();
        $form->setAction('add');
        if ($request->isPost()) {
            if ($form->isValid($request->getPost())) {
                $user  = new Application_Model_User($form->getValues());
                // check whether the user already exist
                if ($mapper->countByUsernameAndMail($user) <= 0) {
                    $mapper->save($user);
                    return $this->_helper->_redirector->gotoSimple('index', 'team', null, array(
                        'token' => Utils_TokenManager::getToken()
                    ));
                } else {
                    echo "Error Handling";
                    // TODO: error handling
                }
            }
        }
        $localUser = new Application_Model_User();
        $mapper->findByUsername(Utils_Authentication_Service::getInfo('username'), $localUser);
        $this->view->localUser = $localUser;
        $this->view->form      = $form;
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
}



