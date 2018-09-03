<?php

class Application_Form_Login extends Zend_Form
{

    public function init()
    {
        // set method to post
        $this->setMethod('post');
        
        // add username field
        $this->addElement('text', 'username', array(
            'placeholder' => 'Benutzername',
            'required' => true,
            'filters' => array(
                'StringTrim'
            ),
            'class' => 'form-control'
        ));
        
        // add password field
        $this->addElement('password', 'password', array(
            'placeholder' => 'Passwort',
            'required' => true,
            'filters' => array(
                'StringTrim'
            ),
            'class' => 'form-control'
        ));
        
        // Add the submit button
        $this->addElement('submit', 'submit', array(
            'ignore' => true,
            'class' => 'btn btn-lg btn-success btn-block',
            'label' => 'Login'
        ));
    }
}

