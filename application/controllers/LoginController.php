<?php

class LoginController extends Zend_Controller_Action
{
    protected $_form;

    protected $_dangerMsgHidden;

    protected $_dangerMsgShown;

    protected $_dangerMsg;

    public function init()
    {
        $this->_form = new Application_Form_Login();
        $this->_form->setAction('login');
        $this->_dangerMsgHidden = "hidden";
        $this->_dangerMsgShown = "";
        $this->_dangerMsg = "Bitte &uuml;berpr&uuml;fen Sie Ihre Eingaben.";
        $this->view->dangerMsgState = $this->_dangerMsgHidden;
    }

    public function indexAction()
    {
        $this->view->form = $this->_form;
        $request = $this->getRequest();
        if ($request->isPost()) {
            if ($this->_form->isValid($request->getPost())) {
                if ($this->_process($this->_form->getValues())) {
                    return $this->redirect('index');
                } else {
                    $this->view->dangerMsgState = $this->_dangerMsgShown;
                    $this->view->dangerMsg = $this->_dangerMsg;
                }
            }
        }
    }

    protected function _process($values)
    {
        // Get our authentication adapter and check credentials
        $adapter = $this->_getAuthAdapter();
        $adapter->setIdentity($values['username']);
        $adapter->setCredential($values['password']);
        
        $auth = Zend_Auth::getInstance();
        $result = $auth->authenticate($adapter);
        if ($result->isValid()) {
            $user = $adapter->getResultRowObject();
            $auth->getStorage()->write($user);
            Utils_Authentication_Service::login($user);
            return true;
        }
        return false;
    }

    protected function _getAuthAdapter()
    {
        $dbAdapter = Zend_Db_Table::getDefaultAdapter();
        $authAdapter = new Zend_Auth_Adapter_DbTable($dbAdapter);
        
        $authAdapter->setTableName('user')
            ->setIdentityColumn('username')
            ->setCredentialColumn('password')
            ->setCredentialTreatment('SHA1(?) AND state=\'active\'');
        
        return $authAdapter;
    }
}



