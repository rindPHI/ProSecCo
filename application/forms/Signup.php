<?php

class Application_Form_Signup extends Zend_Form
{

    public function init()
    {
        $this->setMethod('post');
        
        $this->addElement('text', 'uname', array(
            'label'      => 'User name*:',
            'required'   => true,
            'filters'    => array('StringTrim', 'StringToLower'),
            'validators' => array(
                'Alnum',
            )
        ));
        
        $this->addElement('password', 'password', array(
            'label'      => 'Password*:',
            'required'   => true,
            'filters'    => array('StringTrim'),
//            'validators' => array(
//                array('regex', false, array('pattern' => '/((?=.*\\d)(?=.*[a-z])(?=.*[A-Z]).{6,100})/')),
//            )
        ));
        
//        $this->addElement('password', 'password2', array(
//            'label'      => 'Repeat password*:',
//            'required'   => true,
//            'filters'    => array('StringTrim'),
//            'validators' => array(
//                array('identical', false, array('token' => 'password')),
//            )
//        ));
        
        // Add an email element
        $this->addElement('text', 'email', array(
            'label'      => 'An alternative email address°:',
            'required'   => false,
            'filters'    => array('StringTrim'),
            'validators' => array(
                'EmailAddress',
            )
        ));
        
        $this->addElement('text', 'forename', array(
            'label'      => 'Forename:',
            'required'   => false,
            'filters'    => array('StringTrim'),
        ));
        
        $this->addElement('text', 'surname', array(
            'label'      => 'Surname:',
            'required'   => false,
            'filters'    => array('StringTrim'),
        ));
        
        $this->addElement('text', 'organization', array(
            'label'      => 'Organization:',
            'required'   => false,
            'filters'    => array('StringTrim'),
        ));
        
        $this->addElement('text', 'streetnr', array(
            'label'      => 'Street / Nr.:',
            'required'   => false,
            'filters'    => array('StringTrim'),
        ));
        
        $this->addElement('text', 'zip', array(
            'label'      => 'Zip:',
            'required'   => false,
            'filters'    => array('StringTrim'),
        ));
        
        $this->addElement('text', 'city', array(
            'label'      => 'City:',
            'required'   => false,
            'filters'    => array('StringTrim'),
        ));
        
        $this->addElement('select', 'ccode', array(
            'label'      => 'Country:',
            'required'   => false,
            'filters'    => array('StringTrim'),
        )); 
        
        // Add a captcha
//        $this->addElement('captcha', 'captcha', array(
//            'label'      => 'Please enter the 5 letters displayed below:',
//            'required'   => true,
//            'captcha'    => array(
//                'captcha' => 'Figlet',
//                'wordLen' => 5,
//                'timeout' => 300
//            )
//        ));
 
        // Add the submit button
        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
            'label'    => 'Save',
        ));
 
        // And finally add some CSRF protection
        $this->addElement('hash', 'csrf', array(
            'ignore' => true,
        ));
    }


}

