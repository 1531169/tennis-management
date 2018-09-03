<?php

class Application_Form_AddUser extends Zend_Form
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
        
        // add givenname field
        $this->addElement('text', 'givenname', array(
            'placeholder' => 'Vorname',
            'required' => true,
            'filters' => array(
                'StringTrim'
            ),
            'class' => 'form-control'
        ));
        
        // add surname field
        $this->addElement('text', 'surname', array(
            'placeholder' => 'Nachname',
            'required' => true,
            'filters' => array(
                'StringTrim'
            ),
            'class' => 'form-control'
        ));
        
        // add gender select
        $this->addElement('select', 'gender', array(
            'placeholder' => 'Geschlecht',
            'required' => false,
            'multiOptions' => array(
                'm' => 'maennlich',
                'f' => 'weiblich',
                '-' => 'andere'
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
        
        // add email field
        $this->addElement('text', 'email', array(
            'placeholder' => 'E-Mail',
            'required' => true,
            'filters' => array(
                'StringTrim'
            ),
            'validators' => array(
                'EmailAddress',
            ),
            'class' => 'form-control'
        ));
        
        // add email2 field
        $this->addElement('text', 'email2', array(
            'placeholder' => 'E-Mail (optional)',
            'required' => false,
            'filters' => array(
                'StringTrim'
            ),
            'validators' => array(
                'EmailAddress',
            ),
            'class' => 'form-control'
        ));
        
        // add organiztation select
        $this->addElement('select', 'organization', array(
            'label' => 'Organisation',
            'required' => false,
            'multiOptions' => array(
                '' => 'KEINE',
                'FST' => 'FST',
                'F&CO' => 'F&CO'
            ),
            'class' => 'form-control'
        ));
        
        // add role select
        $this->addElement('select', 'role', array(
            'label' => 'Rolle',
            'required' => true,
            'multiOptions' => array(
                'player' => 'Spieler',
                'coach' => 'Coach'
            ),
            'class' => 'form-control'
        ));
        
        // add state select
        $this->addElement('select', 'state', array(
            'label' => 'Status',
            'required' => true,
            'multiOptions' => array(
                'active' => 'Aktiv',
                'inactive' => 'Inaktiv',
                'disabled' => 'Gesperrt'
            ),
            'class' => 'form-control'
        ));
        
        // Add the submit button
        $this->addElement('submit', 'submit', array(
            'ignore' => true,
            'class' => 'btn btn-lg btn-success btn-block',
            'label' => 'Benutzer anlegen'
        ));
    }
}

