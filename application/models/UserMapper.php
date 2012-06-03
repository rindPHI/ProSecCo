<?php

class Application_Model_UserMapper
{
    /**
     * @var Application_Model_DbTable_User
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
            $this->setDbTable('Application_Model_DbTable_User');
        }
        return $this->_dbTable;
    }
 
    /**
     * @param Application_Model_User $user The user to save.
     * @return int Either uid of new user or -1
     */
    public function save(Application_Model_User $user)
    {
        $data = array(
            'uid'       => $user->getUid(),
            'uname'     => $user->getUname(),
            'publicKey' => $user->getPublicKey(),
            'password'  => hash('sha256', $user->getPassword()),
        );
 
        if (($uid = $user->getUid()) <= 0) {
            unset($data['uid']);
            $uid = $this->getDbTable()->insert($data);
            return $uid;
        } else {
            $this->getDbTable()->update($data, array('uid = ?' => $uid));
            return -1;
        }
    }
 
    public function find($id, Application_Model_User $user)
    {
        $result = $this->getDbTable()->find($id);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $user->setUid($row->uid)
             ->setUname($row->uname)
             ->setPublicKey($row->publicKey)
             ->setPassword($row->password);
    }
    
    /**
     * @param string $column
     * @param mixed $value
     * @return array An array of {@link Application_Model_User}: The query results
     */
    public function findByColumn($column, $value)
    {
        /**
         * @var Zend_Db_Table_Select 
         */
        $select = $this->getDbTable()
                ->select()
                ->where($column . ' = ?', $value);
        
        /**
         * @var Zend_Db_Table_Rowset_Abstract 
         */
        $dbResult = $this->getDbTable()->fetchAll($select);
        
        foreach ($dbResult as $row)
        {
            $user = new Application_Model_User();
            $user->setUid($row->uid)
                ->setUname($row->uname)
                ->setPublicKey($row->publicKey)
                ->setPassword($row->password);
            
            $userdata[] = $user;
        }
        
        return $userdata;
    }
    
    public function fetchAll()
    {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries   = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_User();
            $entry->setUid($row->uid)
                  ->setUname($row->uname)
                  ->setPublicKey($row->publicKey)
                  ->setPassword($row->password);
            $entries[] = $entry;
        }
        return $entries;
    }

}

