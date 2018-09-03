<?php

class Application_Form_EditSaisonplan extends Zend_Form
{
    
    protected $_countOfDays;

    public function __construct(Application_Model_Spielplan $plan, array $planDays, $startDate = null)
    {
        $this->setCountOfDays(sizeof($planDays));
		$options = $this->getDropdownOptions();
        
        $startDate = date('d.m.Y', mktime());
        
        $this->addElement('hidden', 'planid', array(
            'value'	=> $plan->getSpielplan_id(),
            'class'	=> 'form-control'
        ));
        
        $this->addElement('text', 'saison', array(
            'value'	=> $plan->getSaison(),
            'class'	=> 'form-control'
        ));
        
        $fieldCount = 0;
        // create groups of fields for the single days
        foreach ($planDays as $planDay) {
            // add field for day number
            $this->addElement('hidden', 'id' . $fieldCount, array(
                'value'	=> ($planDay->getSpieltag_id()),
            ));
            
            // add field for day number
            $this->addElement('text', 'day' . $fieldCount, array(
                'value'	=> ($fieldCount + 1),
                'class'	=> 'form-control'
            ));
            
            // add field for date
            $this->addElement('text', 'date' . $fieldCount, array(
                'required'	=> true,
                'value'		=> ($planDay->getSpieldatum()),
                'class'		=> 'form-control datepicker'
            ));
            
            // add select of team 1
            $this->addElement('select', '1team' . $fieldCount, array(
                'required'		=> false,
                'value'		    => ($planDay->getTeam1()),
                'multiOptions'	=> $options,
                'class'			=> 'form-control'
            ));
            
            // add select of team 2
            $this->addElement('select', '2team' . $fieldCount, array(
                'required'		=> false,
                'value'		    => ($planDay->getTeam2()),
                'multiOptions'	=> $options,
                'class'			=> 'form-control'
            ));
            $fieldCount++;
        }
        $this->setCountOfDays(($fieldCount + 1));
        $this->addAdditionFormGroup();
        
        // Add the submit button
        $this->addElement('submit', 'submit', array(
            'ignore'    => true,
            'class'     => 'btn btn-lg btn-success btn-block',
            'label'	    => 'Speichern'
        ));
	}
	
	private function addAdditionFormGroup() {
	    
	    $index = $this->getCountOfDays() - 1;
	    $options = $this->getDropdownOptions();
	    // add field for day number
	    $this->addElement('hidden', 'id' . $index, array());
	    
	    // add field for day number
	    $this->addElement('text', 'day' . $index, array(
	        'value'	=> ($index + 1),
	        'class'	=> 'form-control'
	    ));
	    
	    // add field for date
	    $this->addElement('text', 'date' . $index, array(
	        'required'	=> true,
	        'value'		=> '',
	        'class'		=> 'form-control datepicker'
	    ));
	    
	    // add select of team 1
	    $this->addElement('select', '1team' . $index, array(
	        'required'		=> false,
	        'multiOptions'	=> $options,
	        'class'			=> 'form-control'
	    ));
	    
	    // add select of team 2
	    $this->addElement('select', '2team' . $index, array(
	        'required'		=> false,
	        'multiOptions'	=> $options,
	        'class'			=> 'form-control'
	    ));
	}
	
	private function getDropdownOptions() {
		$mapper = new Application_Model_UserMapper();
		$sql	= $mapper->getDbTable()->select()->distinct()->from('user', 'organization');
		$result = $mapper->getDbTable()->fetchAll($sql);
		$options = array('' => 'FREI');
		foreach($result as $row) {
			$options[$row->organization] = $row->organization;
		}
		return $options;
	}

    public function addDaysToDate($date, $days = 7)
    {
        $date = strtotime('+' . $days . ' days', strtotime($date));
        return date('d.m.Y', $date);
    }

    public function init()
    {
        $this->setMethod('post');
    }

    public function getCountOfDays()
    {
        return $this->_countOfDays;
    }

    public function setCountOfDays($countOfDays)
    {
        $this->_countOfDays = $countOfDays;
        return $this->_countOfDays;
    }
}

