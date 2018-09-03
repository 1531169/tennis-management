<?php

class SaisonController extends Zend_Controller_Action
{
    const PATH = '/tennis-management/public/saison/';
    
    const MSG_ERROR_YEAR_DIFF       = 'Saison (Jahr von...) muss kleiner sein als Saison (Jahr bis...).';
    const MSG_ERROR_PLAN_EXISTS     = 'Der Plan der angegebenen Saison existiert bereits!';
    const MSG_SUCCESS_PLAN_CREATED  = 'Der Saisonplan wurde erfolgreich angelegt.';
    
    protected $_dangerMsgHidden = null;
    protected $_dangerMsgShown  = null;
    protected $_dangerMsg       = null;
    
    protected $_successMsgHidden = null;
    protected $_successMsgShown  = null;
    protected $_successMsg       = null;
	
	protected $_role;

    public function init()
    {
		Utils_Authentication_Service::redirectIfNotAuthenticated();
		
        $this->_role = Utils_Authentication_Service::getInfo('role');
        $this->view->role = $this->_role;
		
        $this->_dangerMsgHidden = 'hidden';
        $this->_dangerMsgShown  = '';
        $this->_dangerMsg       = $this::MSG_ERROR_YEAR_DIFF;
        
        $this->_successMsgHidden = 'hidden';
        $this->_successMsgShown  = '';
        $this->_successMsg       = $this::MSG_SUCCESS_PLAN_CREATED;
        
        $this->view->dangerMsgState  = $this->_dangerMsgHidden;
        $this->view->successMsgState = $this->_successMsgHidden;
    }

    public function indexAction()
    {
        // nothing
    }
    
    public function testAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        
        $contextSwitch = $this->_helper->getHelper('contextSwitch');
        $contextSwitch->addActionContext('test', 'json');
        $contextSwitch->initContext('json');
        unset($this->view->dangerMsgState);
        unset($this->view->successMsgState);
        $this->view->processResult = "SUCCESS";
        /* how to call:
        $client = new Zend_Http_Client('http://localhost/tennis-management/public/saison/test');
        $client->setParameterPost(array(
            'language'  => 'es',
            'country'   => 'ar',
            'selection' => array(45, 32, 80)
        ));
        $response = $client->request(Zend_Http_Client::POST);
        $data = json_decode($response->getRawBody());
        if($data->processResult == "SUCCESS") {
            echo "ERFOLG";
        } else {
            echo "ERROR";
        }
        */
    }

    public function viewAction()
    {
        $spielplanMapper = new Application_Model_Spielplanmapper();
        $spieltagMapper  = new Application_Model_Spieltagmapper();
        $request  = $this->getRequest();
        $planId   = (int) $request->getParam('planid');
        $plan     = null;
        $planDays = array();
        $notFound = false;
        if(isset($request)) {
            if(is_numeric((int) $planId) && $planId != 0) {
                $plan = $spielplanMapper->find($planId);
                if($plan == null) {
                    // no plan found => show message
                    $notFound = true;
                    $this->view->dangerMsgState	= $this->_dangerMsgShown;
                    $this->view->dangerMsg		= "Es wurde kein Plan gefunden.";
                } else {
                    $planDays = $spieltagMapper->fetchAllByPlanId($plan->getSpielplan_id());
                }
            }
        }
        
        // no plan found, so take current plan
        if($plan == null && !$notFound) {
            // current plan
            $plan = $spielplanMapper->getCurrentPlan();
            // still no plan?
            if($plan == null) {
                // no plan found => show message
                $notFound = true;
                $this->view->dangerMsgState	= $this->_dangerMsgShown;
                $this->view->dangerMsg		= "Aktuell sind keine Saisonpl&auml;ne vorhanden.";
            } else {
                $planDays = $spieltagMapper->fetchAllByPlanId($plan->getSpielplan_id());
            }
        }
        
        $this->view->plan     = $plan;
        $this->view->planDays = $planDays;
    }

    public function allAction()
    {
        $spielplanMapper = new Application_Model_Spielplanmapper();
        $this->view->plans = $spielplanMapper->fetchAll();
    }
    
    public function prepareAction()
    {
        $request = $this->getRequest();
        $form = new Application_Form_PrepareCreateSaisonplan();
        $form->setAction('prepare');
        
        if ($request->isPost()) {
            if ($form->isValid($request->getPost())) {
                if ($this->_process($form->getValues())) {
                    $this->_helper->_redirector->gotoSimple('add', 'saison', null, array(
                        'days'   => $form->getValues()['countOfDays'],
                        'saison' => $form->getValues()['first'] . $form->getValues()['second'] 
                    ));
                } else {
                    $this->view->dangerMsgState	= $this->_dangerMsgShown;
                    $this->view->dangerMsg		= $this->_dangerMsg;
                }
            }
        }
        $this->view->form = $form;
    }
    
    public function addAction()
    {
        $isFinishToSave = false;
        $request	    = $this->getRequest();
        $countOfDays    = $request->getParam('days');
        $saison		    = $request->getParam('saison');
        if (!$countOfDays) {
            throw new Exception('No days were given to generate the formular.');
        } else if (!$saison) {
            throw new Exception('No saison data were given.');
        }
        
        $form = new Application_Form_CreateSaisonplan($countOfDays, $saison);
        
        if ($request->isPost()) {
            if ($form->isValid($request->getPost())) {
                if (true) {
                    // prevent that formular will be shown again
                    $isFinishToSave = true;
                    $this->createPlan($form->getValues(), $countOfDays);
                } else {
                    $this->view->dangerMsgState	= $this->_dangerMsgShown;
                    $this->view->dangerMsg		= $this->_dangerMsg;
                }
            } else {
                echo 'FEHLER';
            }
        }
        $this->view->isFinishToSave = $isFinishToSave;
        $this->view->form = $form;
    }
    
    private function createPlan($postData, $countOfDays)
    {
        $spielplanMapper = new Application_Model_Spielplanmapper();
        $spieltagMapper  = new Application_Model_Spieltagmapper();
        
        $keysaison  = "saison";
        $keyDay     = "day";
        $keyDate    = "date";
        $keyTeam1   = "1team";
        $keyTeam2   = "2team";
        
        if(!$spielplanMapper->doesSaisonExist($postData[$keysaison])) {
            $spielplan = new Application_Model_Spielplan();
            $spielplan->setSaison($postData[$keysaison]);
            $idOrCountOfUpdatedRows = $spielplanMapper->save($spielplan);
            if($idOrCountOfUpdatedRows > 0) {
                $tage = array();
                for ($i = 0; $i < $countOfDays; $i ++) {
                    $spieltag = new Application_Model_Spieltag();
                    $spieltag->setSpielplan_id($idOrCountOfUpdatedRows);
                    $spieltag->setSpieldatum($postData[$keyDate . $i]);
                    $spieltag->setTeam1($postData[$keyTeam1 . $i]);
                    $spieltag->setTeam2($postData[$keyTeam2 . $i]);
                    $tage[] = $spieltag;
                }
                $spieltagMapper->saveAll($tage);
                // TODO: move messages into const
                $this->view->successMsgState = $this->_successMsgShown;
                $this->view->successMsg		 = $this->_successMsg;
            }
        } else {
            $this->view->dangerMsgState	= $this->_dangerMsgShown;
            $this->view->dangerMsg		= $this::MSG_ERROR_PLAN_EXISTS;
        }
    }
    
    public function editAction()
    {
        $spielplanMapper = new Application_Model_Spielplanmapper();
        $spieltagMapper  = new Application_Model_Spieltagmapper();
        $request  = $this->getRequest();
        $planId   = (int) $request->getParam('planid');
        $plan     = null;
        $planDays = array();
        $notFound = false;
        if(isset($request)) {
            if(is_numeric((int) $planId) && $planId != 0) {
                $plan = $spielplanMapper->find($planId);
                if($plan == null) {
                    // no plan found => show message
                    $notFound = true;
                    $this->view->dangerMsgState	= $this->_dangerMsgShown;
                    $this->view->dangerMsg		= "Es wurde kein Plan gefunden.";
                } else {
                    $planDays = $spieltagMapper->fetchAllByPlanId($plan->getSpielplan_id());
                    $this->editPlanHandleForm($plan, $planDays, $spieltagMapper);
                }
            }
        }
        
        // no plan found, so take current plan
        if($plan == null && !$notFound) {
            // current plan
            $plan = $spielplanMapper->getCurrentPlan();
            // still no plan?
            if($plan == null) {
                // no plan found => show message
                $notFound = true;
                $this->view->dangerMsgState	= $this->_dangerMsgShown;
                $this->view->dangerMsg		= "Aktuell sind keine Saisonpl&auml;ne vorhanden.";
            } else {
                $this->editPlanHandleForm($plan, $planDays, $spieltagMapper);
            }
        }
        
        $this->view->plan     = $plan;
        $this->view->planDays = $planDays;
        
    }
    
    private function editPlanHandleForm($plan, $planDays, &$spieltagMapper)
    {
        $request  = $this->getRequest();
        if(isset($request)) {
            $data = $request->getParams();
            for($i = 0; $i < sizeof($planDays) + 1; $i++) {
                # check whether all fields exists => values not relevant
                if(isset(
                    $data["id" . $i], 
                    $data["date" . $i], 
                    $data["1team" . $i], 
                    $data["2team" . $i])) {
                    if(empty($data["date" . $i])) {
                        continue;
                    }
                    $spieltag = new Application_Model_Spieltag();
                    $spieltag->setSpieltag_id($data["id" . $i]);
                    $spieltag->setSpielplan_id($plan->getSpielplan_id());
                    $spieltag->setSpieldatum($data["date" . $i]);
                    $spieltag->setTeam1($data["1team" . $i]);
                    $spieltag->setTeam2($data["2team" . $i]);
                    $spieltagMapper->save($spieltag);
                }
            }
        }
        $planDays = $spieltagMapper->fetchAllByPlanId($plan->getSpielplan_id());
        $this->view->form = new Application_Form_EditSaisonplan($plan, $planDays);
    }
    
    
    
    /**
     * Checks whether the first value is smaller than the second value.
     * 
     * @param array $values     array with two elements    
     * @return boolean          true if the first is smaller than the second value
     */
    private function _process(array $values)
    {
        $von	= $values['first'];
        $bis	= $values['second'];
        
        if ($von < $bis) {
            return true;
        }
        return false;
    }
}