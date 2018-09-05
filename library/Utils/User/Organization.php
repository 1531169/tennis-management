<?php

/**
 *
 * @author Cedric Reinhard
 *        
 */
class Utils_User_Organization
{
    const DEFAULT_VAL = 'FREI';
    const DEFAULT_KEY = '';
    
    public static function getDropdownOptions()
    {
        $options = array(
            self::DEFAULT_KEY => self::DEFAULT_VAL
        );
        $result = self::getOrganizationArray();
        foreach ($result as $row) {
            $options[$row->organization] = $row->organization;
        }
        return $options;
    }
    
    public static function getDatalistValues()
    {
        $options = array(
            self::DEFAULT_VAL
        );
        $result = self::getOrganizationArray();
        foreach ($result as $row) {
            $options[] = $row->organization;
        }
        return $options;
    }
    
    public static function getHtmlDatalist() {
        $html = '<datalist id="organizations">';
        foreach(self::getDatalistValues() as $option) {
            $html .= '<option value="' . $option . '">';
        }
        $html .= '</datalist>';
        return $html;
    }
    
    private static function getOrganizationArray() {
        $mapper = new Application_Model_UserMapper();
        $sql    = $mapper->getDbTable()
        ->select()
        ->distinct()
        ->from('user', 'organization');
        return $mapper->getDbTable()->fetchAll($sql);
    }
}

