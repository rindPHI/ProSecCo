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
        // action body
    }


}