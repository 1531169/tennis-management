<?php

/**
 * 
 * @author Cedric Reinhard
 *
 */
class Application_Form_EditUser extends Zend_Form
{   
    public function __construct(Application_Model_User $user)
    {
        // add user id field
        $this->addElement('hidden', 'user_id', array(
            'value'	=> $user->getUser_id(),
            'class'	=> 'form-control'
        ));
        
        // add username field
        $this->addElement('text', 'username', array(
            'value'	      => $user->getUsername(),
            'placeholder' => 'Benutzername',
            'readonly'    => true,
            'required'    => true,
            'filters'     => array(
                'StringTrim'
            ),
            'class'       => 'form-control'
        ));
        
        // add givenname field
        $this->addElement('text', 'givenname', array(
            'value'	      => $user->getGivenname(),
            'placeholder' => 'Vorname',
            'required'    => true,
            'filters'     => array(
                'StringTrim'
            ),
            'class'       => 'form-control'
        ));
        
        // add surname field
        $this->addElement('text', 'surname', array(
            'value'	      => $user->getSurname(),
            'placeholder' => 'Nachname',
            'required'    => true,
            'filters'     => array(
                'StringTrim'
            ),
            'class'       => 'form-control'
        ));
        
        // add gender select
        $this->addElement('select', 'gender', array(
            'value'	       => $user->getGender(),
            'placeholder'  => 'Geschlecht',
            'required'     => false,
            'multiOptions' => Utils_User_Gender::getDropdownOptionsArray(),
            'class'        => 'form-control'
        ));
        
        // add password field
        $this->addElement('password', 'password', array(
            'placeholder' => 'Passwort',
            'required'    => false,
            'filters'     => array(
                'StringTrim'
            ),
            'class'       => 'form-control'
        ));
        
        // add email field
        $this->addElement('text', 'email', array(
            'value'	      => $user->getEmail(),
            'placeholder' => 'E-Mail',
            'required'    => true,
            'filters'     => array(
                'StringTrim'
            ),
            'validators'  => array(
                'EmailAddress',
            ),
            'class'       => 'form-control'
        ));
        
        // add email2 field
        $this->addElement('text', 'email2', array(
            'value'	      => $user->getEmail2(),
            'placeholder' => 'E-Mail (optional)',
            'required'    => false,
            'filters'     => array(
                'StringTrim'
            ),
            'validators'  => array(
                'EmailAddress',
            ),
            'class'       => 'form-control'
        ));
        
        // add organiztation text with auto intelisense
        $this->addElement('text', 'organization', array(
            'list'        => 'organizations',
            'placeholder' => 'Organisation',
            'value'	      => $user->getOrganization(),
            'label'       => 'Organisation',
            'required'    => false,
            'filters'     => array(
                'StringTrim'
            ),
            'class'       => 'form-control'
        ));
        /*
         * old version (Problem: no adding from new organizations)
        $this->addElement('select', 'organization', array(
            'list'         => 'organizations',
            'value'	       => $user->getOrganization(),
            'label'        => 'Organisation',
            'required'     => false,
            'multiOptions' => Utils_User_Organization::getDropdownOptions(),
            'class'        => 'form-control'
        ));*/
        
        // add role select
        $this->addElement('select', 'role', array(
            'value'	       => $user->getRole(),
            'label'        => 'Rolle',
            'required'     => true,
            'multiOptions' => Utils_User_Role::getDropdownOptionsArray(),
            'class'        => 'form-control'
        ));
        
        // add state select
        $this->addElement('select', 'state', array(
            'value'	       => $user->getState(),
            'label'        => 'Status',
            'required'     => true,
            'multiOptions' => Utils_User_State::getDropdownOptionsArray(),
            'class'        => 'form-control'
        ));
        
        // Add the submit button
        $this->addElement('submit', 'submit', array(
            'ignore' => true,
            'class' => 'btn btn-lg btn-success btn-block',
            'label' => 'Speichern'
        ));
    }
    
    public function init()
    {
        // set method to post
        $this->setMethod('post');
    }
}