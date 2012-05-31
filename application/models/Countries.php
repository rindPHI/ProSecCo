<?php

class Application_Model_Countries
{

    /**
     * @var string
     */
    protected $_ccode;
    
    /**
     * @var string
     */
    protected $_country;
    
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
            throw new Exception('Invalid country property');
        }
        $this->$method($value);
    }
 
    public function __get($name)
    {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid country property');
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
    
    public function setCcode($ccode)
    {
        $this->_ccode = (string) $ccode;
        return $this;
    }
    
    public function getCcode()
    {
        return $this->_ccode;
    }
    
    public function setCountry($country)
    {
        $this->_country = (string) $country;
        return $this;
    }
    
    public function getCountry()
    {
        return $this->_country;
    }

}

