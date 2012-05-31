<?php

class Application_Model_CountriesMapper
{

    /**
     * @var Application_Model_DbTable_Countries
     */
    protected $_dbTable;
    
    public function setDbTable($dbTable)
    {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
        
        if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception('Invalid table data gateway provided');
        }
        
        $this->_dbTable = $dbTable;
        
        return $this;
    }
    
    public function getDbTable()
    {
        if (null === $this->_dbTable) {
            $this->setDbTable('Application_Model_DbTable_Countries');
        }
        return $this->_dbTable;
    }
 
    /**
     * @param Application_Model_Countries $country The user to save.
     * @return int Either uid of new user or -1
     */
    public function save(Application_Model_Countries $country)
    {
        $data = array(
            'ccode'   => $country->getCcode(),
            'country' => $country->getCountry(),
        );
 
        if (null === ($ccode = $country->getUid())) {
            unset($data['ccode']);
            $ccode = $this->getDbTable()->insert($data);
            return $ccode;
        } else {
            $this->getDbTable()->update($data, array('ccode = ?' => $ccode));
            return -1;
        }
    }
 
    public function find($id, Application_Model_Countries $country)
    {
        $result = $this->getDbTable()->find($id);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $country->setCcode($row->ccode)
             ->setCountry($row->country);
    }
    
    public function fetchAll()
    {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries   = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_Countries();
            $entry->setCcode($row->ccode)
                  ->setCountry($row->country);
            $entries[] = $entry;
        }
        return $entries;
    }

}

