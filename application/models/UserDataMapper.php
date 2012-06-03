<?php

class Application_Model_UserDataMapper
{

    /**
     * @var Application_Model_DbTable_UserData
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
            $this->setDbTable('Application_Model_DbTable_UserData');
        }
        return $this->_dbTable;
    }
 
    /**
     * @param Application_Model_UserData $userdata The user data to save.
     * @return nothing
     */
    public function save(Application_Model_UserData $userdata)
    {
        $data = array(
            'uid'          => $userdata->getUid(),
            'forename'     => $userdata->getForename(),
            'surname'      => $userdata->getSurname(),
            'organization' => $userdata->getOrganization(),
            'email'        => $userdata->getEmail(),
            'streetnr'     => $userdata->getStreetnr(),
            'zip'          => $userdata->getZip(),
            'city'         => $userdata->getCity(),
            'ccode'        => $userdata->getCcode(),
        );
        
        $this->getDbTable()->insert($data);
    }
    
    /**
     * @param Application_Model_UserData $userdata The user data to save.
     * @return nothing
     */
    public function update(Application_Model_UserData $userdata)
    {
        $data = array(
            'uid'          => $userdata->getUid(),
            'forename'     => $userdata->getForename(),
            'surname'      => $userdata->getSurname(),
            'organization' => $userdata->getOrganization(),
            'email'        => $userdata->getEmail(),
            'streetnr'     => $userdata->getStreetnr(),
            'zip'          => $userdata->getZip(),
            'city'         => $userdata->getCity(),
            'ccode'        => $userdata->getCcode(),
        );
 
        $this->getDbTable()->update($data, array('uid = ?' => $userdata->getUid()));
    }
 
    public function find($id, Application_Model_UserData $userdata)
    {
        $result = $this->getDbTable()->find($id);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        
        $userdata->setUid($row->uid)
            ->setForename($row->forename)
            ->setSurname($row->surname)
            ->setOrganization($row->organization)
            ->setEmail($row->email)
            ->setStreetnr($row->streetnr)
            ->setZip($row->zip)
            ->setCity($row->city)
            ->setCcode($row->ccode);
    }
    
    /**
     * @param string $column
     * @param mixed $value
     * @param array $userdata Array of {@link Application_Model_UserData}: The Results
     */
    public function findByColumn($column, $value, $userdata)
    {
        /**
         * @var Zend_Db_Table_Rowset_Abstract 
         */
        $dbResult = $this->getDbTable()->fetchAll(array($column => $value));
        
        foreach ($dbResult as $row)
        {
            $user = new Application_Model_UserData();
            $user->setUid($row->uid)
                ->setForename($row->forename)
                ->setSurname($row->surname)
                ->setOrganization($row->organization)
                ->setEmail($row->email)
                ->setStreetnr($row->streetnr)
                ->setZip($row->zip)
                ->setCity($row->city)
                ->setCcode($row->ccode);
            
            $userdata[] = $user;
        }
    }
    
    public function fetchAll()
    {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries   = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_UserData();
            $entry->setUid($row->uid)
                  ->setForename($row->forename)
                  ->setSurname($row->surname)
                  ->setOrganization($row->organization)
                  ->setEmail($row->email)
                  ->setStreetnr($row->streetnr)
                  ->setZip($row->zip)
                  ->setCity($row->city)
                  ->setCcode($row->ccode);
            $entries[] = $entry;
        }
        return $entries;
    }

}

