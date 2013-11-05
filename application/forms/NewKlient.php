<?php

class Application_Form_NewKlient extends Zend_Form
{

    public function init()
    {
        $this->setAction('create')->setMethod('post');
        
        
        $filterTrim = new Zend_Filter_StringTrim();
        $validatorNotEmpty = new Zend_Validate_NotEmpty();
        $validatorNotEmpty->setMessage('To pole jest wymagane.');
        
        $validatorAlnum = new Zend_Validate_Alnum();
        $validatorAlnum->setMessage('Dopuszczalne sa wylacznie znaki alfanumeryczne');
        $validatorStringLength = new Zend_Validate_StringLength(3,32);
        $validatorStringLength->setMessages(array(
            Zend_Validate_StringLength::TOO_SHORT => 'Imie nie moze byc krotsze niz 3 znaki.',
            Zend_Validate_StringLength::TOO_LONG  => 'Imie nie moze byc dluzsze niz 32 znaki.'
        ));
        $imie = new Zend_Form_Element_Text('imie');
        $imie->setRequired(true)->setLabel('Imie: ')
                ->addFilter($filterTrim)
                ->addValidator($validatorNotEmpty)
                ->addValidator($validatorAlnum)
                ->addValidator($validatorStringLength);
        $imie->addDecorators(array(
            array('Errors'),
        ));
        $this->addElement($imie);
                
        
        
        $this->addElement('text', 'nazwisko', array('label' => 'Nazwisko: '));
        
        $this->addElement('text', 'Mail', array('label' => 'E-mail: '));
        $this->addElement('password', 'Haslo', array('label' => 'Haslo: '));
        $this->addElement('password', 'potwierdzenie_hasla', array('label' => 'Powtorz haslo: '));
        
        $this->addElement('text', 'telefon', array('label' => 'Nr Telefonu: '));
        $this->addElement('text', 'data_urodzenia', array('label' => 'Data Urodzenia: '));
        
        $this->addElement('submit', 'register', array('label' => 'Zarejestruj sie!'));
    }


}

