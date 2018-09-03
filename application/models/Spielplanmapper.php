<?php

class Application_Model_Spielplanmapper
{

    protected $_dbTable;

    public function setDbTable($dbTable)
    {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
        if (! $dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception('Invalid table data gateway provided');
        }
        $this->_dbTable = $dbTable;
        return $this;
    }

    public function getDbTable()
    {
        if ($this->_dbTable === null) {
            $this->setDbTable('Application_Model_DbTable_Spielplan');
        }
        return $this->_dbTable;
    }

    public function save(Application_Model_Spielplan $spielplan)
    {
        $data = array(
            'saison' => $spielplan->getSaison()
        );
        if (($id = $spielplan->getSpielplan_id()) === null) {
            unset($data['spielplan_id']);
            return $this->getDbTable()->insert($data);
        } else {
            return $this->getDbTable()->update($data, array(
                'spielplan_id = ?' => $id
            ));
        }
    }

    public function find($id)
    {
        $result = $this->getDbTable()->find($id);
        if (count($result) == 0) {
            return;
        }
        $row = $result->current();
        return $this->getSpielplanObjFromRow($row);
    }
    
    public function findBySeason($saison)
    {
        $result = $this->getDbTable()->fetchAll("saison='$saison'");
        if (count($result) == 0) {
            return;
        }
        $row = $result->current();
        return $this->getSpielplanObjFromRow($row);
            
    }
    
    public function doesSaisonExist($saison)
    {
        $result = $this->getDbTable()->fetchAll("saison='$saison'");
        if (count($result) == 0) {
            return false;
        } else {
            return true;
        }
    }
    
    public function fetchAll()
    {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach($resultSet as $row) {
            $entries[] = $this->getSpielplanObjFromRow($row);;
        }
        return $entries;
    }
    
    public function getCurrentPlan() {
        $row = $this->getDbTable()->fetchRow(null, "spielplan_id DESC");
        if(count($row) == 0) {
            return null;
        }
        return $this->getSpielplanObjFromRow($row);
    }
    
    private function getSpielplanObjFromRow($row) {
        $spielplan = new Application_Model_Spielplan();
        $spielplan->setSpielplan_id($row->spielplan_id);
        $spielplan->setSaison($row->saison);
        return $spielplan;
    }
}

?>