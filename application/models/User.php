<?php

class Application_Model_User
{

    protected $_uid;
    protected $_uname;
    protected $_publicKey;
    protected $_password;
    
    public function __construct(array $options = null)
    {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }
    
    public function __set($name, $value)
    {
        $method = 'set' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid user property');
        }
        $this->$method($value);
    }
 
    public function __get($name)
    {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid user property');
        }
        return $this->$method();
    }

    public function setOptions(array $options)
    {
        $methods = get_class_methods($this);
        foreach ($options as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (in_array($method, $methods)) {
                $this->$method($value);
            }
        }
        return $this;
    }
    
    public function setUid($uid)
    {
        $this->_uid = (int) $uid;
        return $this;
    }
    
    public function getUid()
    {
        return $this->_uid;
    }
    
    public function setUname($uname)
    {
        $this->_uname = (string) $uname;
        return $this;
    }
    
    public function getUname()
    {
        return $this->_uname;
    }

    public function setPublicKey($publicKey)
    {
        $this->_publicKey = (string) $publicKey;
        return $this;
    }
    
    public function getPublicKey()
    {
        return $this->_publicKey;
    }
    
    public function setPassword($password)
    {
        $this->_password = (string) $password;
        return $this;
    }
    
    public function getPassword()
    {
        return $this->_password;
    }
}

