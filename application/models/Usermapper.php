<?php

class Application_Model_Usermapper
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
            $this->setDbTable('Application_Model_DbTable_User');
        }
        return $this->_dbTable;
    }

    public function save(Application_Model_User $user)
    {
        $data = array(
            'state'		   => $user->getState(),
            'role'		   => $user->getRole(),
            'surname'	   => $user->getSurname(),
            'givenname'	   => $user->getGivenname(),
            'gender'	   => $user->getGender(),
            'username'	   => $user->getUsername(),
            'password'	   => SHA1($user->getPassword()),
            'email'		   => $user->getEmail(),
            'email2'	   => $user->getEmail2(),
            'organization' => $user->getOrganization()
        );
        if (($id = $user->getUser_id()) === null) {
            unset($data['user_id']);
            $this->getDbTable()->insert($data);
        } else {
            $this->getDbTable()->update($data, array(
                'user_id = ?' => $id
            ));
        }
    }
    
    public function update(Application_Model_User $user) {
        $data = array(
            'state'		   => $user->getState(),
            'role'		   => $user->getRole(),
            'surname'	   => $user->getSurname(),
            'givenname'	   => $user->getGivenname(),
            'gender'	   => $user->getGender(),
            'username'	   => $user->getUsername(),
            'email'		   => $user->getEmail(),
            'email2'	   => $user->getEmail2(),
            'organization' => $user->getOrganization()
        );
        // overwrite password only if changed
        if(!empty($user->getPassword())) {
            $data['password'] = SHA1($user->getPassword());
        }
        echo "<h1>UserID: " . $user->getUser_id() . "</h1>";
        if (($id = $user->getUser_id()) !== null) {
            $this->getDbTable()->update($data, array(
                'user_id = ?' => $id
            ));
            return true;
        }
        return false;
    }

    public function find($id, Application_Model_User $user)
    {
        $result = $this->getDbTable()->find($id);
        if (count($result) == 0) {
            return;
        }
        $row = $result->current();
        $user->setUser_id($row->user_id)
			->setState($row->state)
			->setRole($row->role)
			->setSurname($row->surname)
			->setGivenname($row->givenname)
			->setGender($row->gender)
			->setUsername($row->username)
			->setPassword($row->password)
			->setEmail($row->email)
			->setEmail2($row->email2)
			->setOrganization($row->organization);
    }
    
    public function fetchAll()
    {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach($resultSet as $row) {
            $entry = new Application_Model_User();
            $entry->setUser_id($row->user_id)
				->setState($row->state)
				->setRole($row->role)
				->setSurname($row->surname)
				->setGivenname($row->givenname)
				->setGender($row->gender)
				->setUsername($row->username)
				->setPassword($row->password)
				->setEmail($row->email)
				->setEmail2($row->email2)
				->setOrganization($row->organization);
            $entries[] = $entry;
        }
        return $entries;
    }
    
    /*
     * TODO: Anpassen für die Suchen nach dem Team 
     */
    public function fetchAllFromTeam() {
        $select = $this->getDbTable()->select()->where('user_id < 3');
        $resultSet = $this->getDbTable()->fetchAll($select);
        foreach($resultSet as $row) {
            $entry = new Application_Model_User();
            $entry->setUser_id($row->user_id)
				->setState($row->state)
				->setRole($row->role)
				->setSurname($row->surname)
				->setGivenname($row->givenname)
				->setGender($row->gender)
				->setUsername($row->username)
				->setPassword($row->password)
				->setEmail($row->email)
				->setEmail2($row->email2)
				->setOrganization($row->organization);
            $entries[] = $entry;
        }
        return $entries;
    }
}

?>