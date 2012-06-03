<?php

class SignupController extends Zend_Controller_Action
{

    /**
     * @var Application_Form_Signup 
     *
     *
     */
    protected $form = null;

    public function init()
    {
                
    }

    public function indexAction()
    {
        
    }

    private function initForm()
    {
        $this->form = new Application_Form_Signup();
        
        /**
         *@var Zend_Form_Element_Select 
         */
        $ccodeElement = $this->form->getElement("ccode");
        
        $countriesMapper = new Application_Model_CountriesMapper();
        $dbResult = $countriesMapper->fetchAll();
        $ccodeElement->addMultiOption('', '');
        foreach ($dbResult as $row)
        {
            $ccodeElement->addMultiOption($row->getCcode(), $row->getCountry());
        }
    }

    public function insertDataAction()
    {
        $this->initForm();
        $request = $this->getRequest();
 
        if ($this->getRequest()->isPost()) {
            if ($this->form->isValid($request->getPost())) {
                $userData = new Application_Model_UserComplete($this->form->getValues());
                $mapper = new Application_Model_UserCompleteMapper();
                $mapper->save($userData);
                
                Prosecco_Authentication::getInstance()->authenticate(
                    $userData->__get('Uname'),
                    $userData->__get('Password')
                );
                
                return $this->_helper->redirector('create-keys');
            }
        }
        
        $this->view->form = $this->form;
    }

    public function createKeysAction()
    {
        
        if (($username = Prosecco_Authentication::getInstance()->loggedInAs()) != false)
        {
            $this->view->userName = $username;
            
            // Get UID
            $userMapper = new Application_Model_UserMapper();
            $userdata = $userMapper->findByColumn("uname", $username);            
            $uid = $userdata[0]->getUid();
            
            // Get real name
            $userdata = new Application_Model_UserData();
            $userDataMapper = new Application_Model_UserDataMapper();
            $userDataMapper->find($uid, $userdata);
            
            if ($userdata !== null)
            {                
                $this->view->realName =
                    $this->buildRealName($userdata->getForename(), $userdata->getSurname());
            }
            else
            {
                $this->view->realName = null;
            }
        }
        else
        {
            //TODO require authentication
        }
        
    }
    
    /**
     * @param string $forename
     * @param string $surname
     * @return string A combination of forename and surname or only one of both
     *                parameters if any of them is null 
     */
    private function buildRealName($forename, $surname)
    {
        $separator = ' ';
        
        if ($forename === null)
        {
            $forename = '';
        }
        
        if ($surname === null)
        {
            $surname = '';
        }
        
        if ($forename == '' || $surname == '')
        {
            $separator = '';
        }
        
        return $forename . $separator . $surname;
    }


}