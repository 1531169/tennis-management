<?php

class Application_Model_Spieltagmapper
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
            $this->setDbTable('Application_Model_DbTable_Spieltag');
        }
        return $this->_dbTable;
    }

    public function save(Application_Model_Spieltag $spieltag)
    {
        $data = array(
            'spielplan_id'  => $spieltag->getSpielplan_id(),
            'spieldatum'    => $spieltag->getSpieldatumInUS(),
            'team1'         => $spieltag->getTeam1(),
            'team2'         => $spieltag->getTeam2()
        );
        # == because in request comes during edit 0 for new entries
        if (($id = $spieltag->getSpieltag_id()) == null) {
            unset($data['spieltag_id']);
            return $this->getDbTable()->insert($data);
        } else {
            return $this->getDbTable()->update($data, array(
                'spieltag_id = ?' => $id
            ));
        }
    }
    
    public function saveAll(array $spieltage)
    {
        foreach ($spieltage as $spieltag) {
            // important to transform here date to english date!
            $data = array(
                'spielplan_id'  => $spieltag->getSpielplan_id(),
                'spieldatum'    => $spieltag->getSpieldatumInUS(),
                'team1'         => $spieltag->getTeam1(),
                'team2'         => $spieltag->getTeam2()
            );
            if (($id = $spieltag->getSpieltag_id()) === null) {
                unset($data['spieltag_id']);
                $this->getDbTable()->insert($data);
            } else {
                $this->getDbTable()->update($data, array(
                    'spieltag_id = ?' => $id
                ));
            }
        }
    }

    public function find($id, Application_Model_Spieltag $spieltag)
    {
        $result = $this->getDbTable()->find($id);
        if (count($result) == 0) {
            return;
        }
        $row = $result->current();
        return $spieltag
            ->setSpieltag_id($row->spieltag_id)
            ->setSpielplan_id($row->spielplan_id)
			->setSpieldatum($row->spieldatum)
			->setTeam1($row->team1)
			->setTeam2($row->team2);
    }
    
    public function fetchAll()
    {
        $select = $this->getDbTable()
            ->select()
            ->from("spieltag", array(
            "spieltag_id",
            "spielplan_id",
            "DATE_FORMAT(spieldatum,'%d.%m.%Y') AS spieldatum",
            "team1",
            "team2"
        ));
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach($resultSet as $row) {
            $entry = new Application_Model_Spieltag();
            $entry->setSpieltag_id($row->spieltag_id)
                ->setSpielplan_id($row->spielplan_id)
                ->setSpieldatum($row->spieldatum)
                ->setTeam1($row->team1)
                ->setTeam2($row->team2);
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function fetchAllByPlanId($planId)
    {
        $select = $this->getDbTable()
            ->select()
            ->from("spieltag", array(
                "spieltag_id",
                "spielplan_id",
                "DATE_FORMAT(spieldatum,'%d.%m.%Y') AS spieldatum",
                "team1",
                "team2"
            ))
            ->where("spielplan_id=$planId");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach($resultSet as $row) {
            $entry = new Application_Model_Spieltag();
            $entry->setSpieltag_id($row->spieltag_id);
            $entry->setSpielplan_id($row->spielplan_id);
            $entry->setSpieldatum($row->spieldatum);
            $entry->setTeam1($row->team1);
            $entry->setTeam2($row->team2);
            $entries[] = $entry;
        }
        return $entries;
    }
}

?>