<?php

class Application_Model_UserData
{

    protected $_uid;
    protected $_forename;
    protected $_surname;
    protected $_organization;
    protected $_email;
    protected $_streetnr;
    protected $_zip;
    protected $_city;
    protected $_ccode;
    
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
    
    public function setForename($forename)
    {
        $this->_forename = (string) $forename;
        return $this;
    }
    
    public function getForename()
    {
        return $this->_forename;
    }

    public function setSurname($surname)
    {
        $this->_surname = (string) $surname;
        return $this;
    }
    
    public function getSurname()
    {
        return $this->_surname;
    }
    
    public function setOrganization($organization)
    {
        $this->_organization = (string) $organization;
        return $this;
    }
    
    public function getOrganization()
    {
        return $this->_organization;
    }

    public function setEmail($email)
    {
        $this->_email = (string) $email;
        return $this;
    }
    
    public function getEmail()
    {
        return $this->_email;
    }
    
    public function setStreetnr($streetnr)
    {
        $this->_streetnr = (string) $streetnr;
        return $this;
    }
    
    public function getStreetnr()
    {
        return $this->_streetnr;
    }
    
    public function setZip($zip)
    {
        $this->_zip = (string) $zip;
        return $this;
    }
    
    public function getZip()
    {
        return $this->_zip;
    }
    
    public function setCity($city)
    {
        $this->_city = (string) $city;
        return $this;
    }
    
    public function getCity()
    {
        return $this->_city;
    }
    
    public function setCcode($ccode)
    {
        $this->_ccode = (string) $ccode;
        return $this;
    }
    
    public function getCcode()
    {
        return $this->_ccode;
    }
    
}

