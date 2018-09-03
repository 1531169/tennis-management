<?php

class Application_Form_PrepareCreateSaisonplan extends Zend_Form
{

    public function init()
    {
        $this->setMethod('post');
        
        // fields to enter saison
        $this->addElement('text', 'first', array(
            'label'			=> 'Saison (Jahr von...)',
			'placeholder'	=> date("Y"),
			'value'			=> date("Y"),
            'required'		=> true,
            'validators'	=> array(
                array(
                    'validator'	=> 'StringLength',
                    'options'	=> array(
                        'min'		=> 4,
                        'max'	=> 4,
                        'messages' => array(
                            'stringLengthTooShort'	=> 'Die Eingabe ist zu kurz.',
                            'stringLengthTooLong'		=> 'Die Eingabe ist zu lang.'
                        )
                    )
                ),
                array(
                    'validator'	=> 'NotEmpty',
                    'options'	=> array(
                        'messages' 	=> array(
                            'isEmpty'	=> utf8_encode('Bitte ausfüllen.')
                        )
                    )
                ),
                array(
                    'validator'	=> 'Digits',
                    'options'	=> array(
                        'messages' => array(
                            'notDigits'				=> '"%value%" darf nur aus Zahlen bestehen.',
                            'digitsStringEmpty'	=> 'Bitte machen Sie eine Eingabe.',
                            'digitsInvalid'			=> 'Invalid type given. String, integer or float expected'
                        )
                    )
                )
            ),
            'class' => 'form-control'
        ));
        
        // between them is a slash (/)
        
        // fields to enter saison
        $this->addElement('text', 'second', array(
            'label'			=> 'Saison (Jahr bis...)',
			'placeholder'	=> date("Y") + 1,
			'value'			=> date("Y") + 1,
            'required'		=> true,
            'validators'	=> array(
                array(
                    'validator'	=> 'StringLength',
                    'options'	=> array(
                        'min'		=> 4,
                        'max'	=> 4,
                        'messages' => array(
                            'stringLengthTooShort'	=> 'Die Eingabe ist zu kurz.',
                            'stringLengthTooLong'		=> 'Die Eingabe ist zu lang.'
                        )
                    )
                ),
                array(
                    'validator'	=> 'NotEmpty',
                    'options'	=> array(
                        'messages'	=> array(
                            'isEmpty'	=> utf8_encode('Bitte ausfüllen.')
                        )
                    )
                ),
                array(
                    'validator'	=> 'Digits',
                    'options'	=> array(
                        'messages' => array(
                            'notDigits'				=> '"%value%" darf nur aus Zahlen bestehen.',
                            'digitsStringEmpty'	=> 'Bitte machen Sie eine Eingabe.',
                            'digitsInvalid' 		=> 'Invalid type given. String, integer or float expected'
                        )
                    )
                )
            ),
            'class' => 'form-control'
        ));
        
        // field for count of days
        $this->addElement('text', 'countOfDays', array(
            'label'			=> 'Anzahl Spieltage',
			'placeholder'	=> 'xx',
            'required'		=> true,
            'validators'	=> array(
                array(
                    'validator'	=> 'StringLength',
                    'options'	=> array(
                        'min'		=> 1,
                        'max'	=> 2,
                        'messages' => array(
                            'stringLengthTooShort'	=> 'Die Eingabe ist zu kurz.',
                            'stringLengthTooLong'		=> 'Die Eingabe ist zu lang.'
                        )
                    )
                ),
                array(
                    'validator'	=> 'NotEmpty',
                    'options'	=> array(
                        'messages'	=> array(
                            'isEmpty'	=> utf8_encode('Bitte ausfüllen.')
                        )
                    )
                ),
                array(
                    'validator'	=> 'Digits',
                    'options'	=> array(
                        'messages' => array(
                            'notDigits'				=> '"%value%" darf nur aus Zahlen bestehen.',
                            'digitsStringEmpty'	=> 'Bitte machen Sie eine Eingabe.',
                            'digitsInvalid'			=> 'Invalid type given. String, integer or float expected'
                        )
                    )
                )
            ),
            'class' => 'form-control'
        ));
        
        // Add the submit button
        $this->addElement('submit', 'submit', array(
            'ignore'	=> true,
            'class'	=> 'btn btn-lg btn-success btn-block',
            'label'	=> 'Weiter'
        ));
    }
}

