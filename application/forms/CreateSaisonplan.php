<?php

class Application_Form_CreateSaisonplan extends Zend_Form
{

    protected $_countOfDays;

    public function __construct($countOfDays, $saison, $startDate = null)
    {
        $this->setCountOfDays($countOfDays);
		$options = $this->getDropdownOptions();
		
        if (strlen($saison) != 8) {
            throw new Exception('The given length of the saison is invalid.');
        }
        $arrSaison = str_split($saison, 4);
        
        $startDate = date('d.m.Y', mktime(0, 0, 0, 10, 10, 2017));
        
        $this->addElement('text', 'saison', array(
            'value'	=> $arrSaison[0] . '/' . $arrSaison[1],
            'class'	=> 'form-control'
        ));
        
        // create groups of fields for the single days
        for ($fieldCount = 0; $fieldCount < $this->getCountOfDays(); $fieldCount ++) {
            // add field for day number
            $this->addElement('text', 'day' . $fieldCount, array(
                'value'	=> ($fieldCount + 1),
                'class'	=> 'form-control'
            ));
            
            // add field for date
            $this->addElement('text', 'date' . $fieldCount, array(
                'required'	=> true,
                'value'		=> $startDate,
                'class'		=> 'form-control datepicker'
            ));
            $startDate = $this->addDaysToDate($startDate);
			
            // add select of team 1
            $this->addElement('select', '1team' . $fieldCount, array(
                'required'		=> false,
                'multiOptions'	=> $options,
                'class'			=> 'form-control'
            ));
            
            // add select of team 2
            $this->addElement('select', '2team' . $fieldCount, array(
                'required'		=> false,
                'multiOptions'	=> $options,
                'class'			=> 'form-control'
            ));
        }
        
        // Add the submit button
        $this->addElement('submit', 'submit', array(
            'ignore'    => true,
            'class'     => 'btn btn-lg btn-success btn-block',
            'label'	    => 'Fertigstellen'
        ));
	}
	
	protected function getDropdownOptions() {
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

