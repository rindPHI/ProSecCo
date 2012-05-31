<?php

class Application_Model_UserCompleteMapper
{

    /**
     *@var Application_Model_UserMapper
     */
    protected $_userMapper;
    
    /**
     *@var Application_Model_UserDataMapper
     */
    protected $_userDataMapper;
    
    public function __construct()
    {
        $this->_userMapper = new Application_Model_UserMapper();
        $this->_userDataMapper = new Application_Model_UserDataMapper();
    }
    
    public function setUserMapper($userMapper)
    {
        $this->_userMapper = (int) $userMapper;
        return $this;
    }
    
    public function getUserMapper()
    {
        return $this->_userMapper;
    }
     
    /**
     * @param Application_Model_User $user The user to save.
     * @return int Either uid of new user or -1
     */
    public function save(Application_Model_UserComplete $user)
    {        
        $userArray = array(
            'uid'       => -1,
            'uname'     => $user->__get('Uname'),
            'publicKey' => $user->__get('PublicKey'),
            'password'  => $user->__get('Password'),
        );
        
        $userDataArray = array(
            'uid'          => '',
            'forename'     => $user->__get('Forename'),
            'surname'      => $user->__get('Surname'),
            'organization' => $user->__get('Organization'),
            'email'        => $user->__get('Email'),
            'streetnr'     => $user->__get('Streetnr'),
            'zip'          => $user->__get('Zip'),
            'city'         => $user->__get('City'),
            'ccode'        => $user->__get('Ccode'),
        );
 
        $user = new Application_Model_User($userArray);        
        $userMapper = new Application_Model_UserMapper();        
        $uid = $userMapper->save($user);        
        
        // Check if there was any user data given
        $checkEmptyVal = implode('', $userDataArray);
        if (empty($checkEmptyVal))
        {
            return;
        }
        
        $userDataArray['uid'] = $uid;
        
        $userData = new Application_Model_UserData($userDataArray);
        $userDataMapper = new Application_Model_UserDataMapper();
        $userDataMapper->save($userData);
    }
    
    public function fetchAll()
    {
        $resultSetUser = $this->_userMapper->fetchAll();
        
        $entries   = array();
        
        foreach ($resultSetUser as $row) {
            $entry = new Application_Model_UserComplete();            
            $entry->setUserModel($row);
            
            $userdata = new Application_Model_UserData();
            $this->_userDataMapper->find($row->getUid(), $userdata);            
            $entry->setUserDataModel($userdata);
            
            $entries[] = $entry;
        }
        return $entries;
    }

}

