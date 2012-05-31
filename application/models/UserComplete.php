<?php

class Application_Model_UserComplete
{
    /**
     * @var Application_Model_User
     */
    protected $_userModel;
    
    /**
     * @var Application_Model_UserData 
     */
    protected $_userDataModel;
    
    public function __construct(array $options = null)
    {
        $this->_userModel = new Application_Model_User;
        $this->_userDataModel = new Application_Model_UserData;
        
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }
    
    public function __set($name, $value)
    {
        $method = 'set' . $name;
        if (('mapper' != $name) && method_exists($this->_userModel, $method)) {
            $this->_userModel->$method($value);
        }
        elseif (('mapper' != $name) && method_exists($this->_userDataModel, $method)) {
            $this->_userDataModel->$method($value);
        }
        elseif (('mapper' != $name) && method_exists($this, $method)) {
            $this->$method($value);
        }
        else
        {
            throw new Exception('Invalid user / user data property');
        }
    }
 
    public function __get($name)
    {
        $method = 'get' . $name;
        if (('mapper' != $name) && method_exists($this->_userModel, $method)) {
            return $this->_userModel->$method();
        }
        elseif (('mapper' != $name) && method_exists($this->_userDataModel, $method)) {
            return $this->_userDataModel->$method();
        }
        elseif (('mapper' != $name) && method_exists($this, $method)) {
            return $this->$method();
        }
        else
        {
            throw new Exception('Invalid user / user data property');
        }
    }

    public function setOptions(array $options)
    {
        $userMethods = get_class_methods($this->_userModel);
        $userDataMethods = get_class_methods($this->_userDataModel);
        
        foreach ($options as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (in_array($method, $userMethods)) {
                $this->_userModel->$method($value);
            }
            elseif (in_array($method, $userDataMethods)) {
                $this->_userDataModel->$method($value);
            }
        }
        return $this;
    }
    
    public function setUserModel($userModel)
    {
        $this->_userModel = $userModel;
        return $this;
    }
    
    public function getUserModel()
    {
        return $this->_userModel;
    }
    
    public function setUserDataModel($userDataModel)
    {
        $this->_userDataModel = $userDataModel;
        return $this;
    }
    
    public function getUserDataModel()
    {
        return $this->_userDataModel;
    }

}

