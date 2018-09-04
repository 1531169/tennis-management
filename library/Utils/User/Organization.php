<?php

/**
 *
 * @author Cedric Reinhard
 *        
 */
class Utils_User_Organization
{
    public static function getDropdownOptions()
    {
        $mapper = new Application_Model_UserMapper();
        $sql = $mapper->getDbTable()
            ->select()
            ->distinct()
            ->from('user', 'organization');
        $result = $mapper->getDbTable()->fetchAll($sql);
        $options = array(
            '' => 'FREI'
        );
        foreach ($result as $row) {
            $options[$row->organization] = $row->organization;
        }
        return $options;
    }
}

