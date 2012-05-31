<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Authentication
 *
 * @author Dominic Scheurer
 */
class Prosecco_Authentication
{
    
    /**
     * @var Prosecco_Authentication
     */
    private static $_instance;
    
    /**
     * @var Zend_Auth_Adapter_DbTable
     */
    private static $_authAdapter;
    
    private function __construct()
    {
        //dbname => (string) The name of the database to user
        //username => (string) Connect to the database as this username.
        //password => (string) Password associated with the username.
        //host => (string) What host to connect to, defaults to localhost
        
        $dbAdapter = Zend_Db_Table_Abstract::getDefaultAdapter();
        
        self::$_authAdapter = new Zend_Auth_Adapter_DbTable(
            $dbAdapter,
            'User',
            'uname',
            'password',
            'SHA2(?, 256)'
        );
    }
    
    /**
     * @return Prosecco_Authentication 
     */
    public static function getInstance()
    {
        if (!(self::$_instance instanceof Prosecco_Authentication))
        {
            self::$_instance = new Prosecco_Authentication();
        }
        
        return self::$_instance;
    }
    
    /**
     * @param string $uname
     * @param string $password 
     * @return bool True iff login attempt was successful
     */
    public function authenticate($uname, $password)
    {
        self::$_authAdapter
            ->setIdentity($uname)
            ->setCredential($password);
        
        return Zend_Auth::getInstance()->authenticate(self::$_authAdapter)->isValid();
        
//        return self::$_authAdapter->authenticate()->isValid();
    }
    
    /**
     * @return mixed User name if logged in, else false.
     */
    public function loggedInAs()
    {
        $auth = Zend_Auth::getInstance();
        if ($auth->hasIdentity())
        {
            return $auth->getIdentity();
        }
        else
        {
            return false;
        }
    }
    
    public function logout()
    {
        Zend_Auth::getInstance()->clearIdentity();
    }
}

?>
