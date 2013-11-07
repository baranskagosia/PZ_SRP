<?php

class Application_Form_NewKlient extends Zend_Form
{

    public function init()
    {
        $this->setAction('create')->setMethod('post');
        
        $filterTrim = new Zend_Filter_StringTrim();
        $validatorNotEmpty = new Zend_Validate_NotEmpty();
        $validatorNotEmpty->setMessage('To pole jest wymagane.');
        
        $mail = new Zend_Form_Element_Text("Mail");
        $validatorHostname = new Zend_Validate_Hostname();
        $validatorHostname->setMessages(array(
            Zend_Validate_Hostname::IP_ADDRESS_NOT_ALLOWED => "'%value%' zdaje się być adresem IP, które są niedopuszczalne",
            Zend_Validate_Hostname::UNKNOWN_TLD => "Nieznana nazwa DNS",
            Zend_Validate_Hostname::INVALID_DASH => "Nazwa DNS zawiera myślnik (-) na niewłaściwej pozycji",
            Zend_Validate_Hostname::INVALID_HOSTNAME_SCHEMA => "Niewłaściwa struktura nazwy DNS",
            Zend_Validate_Hostname::UNDECIPHERABLE_TLD => "Nie można uzyskać nazwy TLD.",
            Zend_Validate_Hostname::INVALID_HOSTNAME => "Niewłaściwa struktura nazwy DNS.",
            Zend_Validate_Hostname::INVALID_LOCAL_NAME => "Niewłaściwa część lokalna adresu.",
            Zend_Validate_Hostname::LOCAL_NAME_NOT_ALLOWED => "Nie wiem ocb."
                )
        );

        $validatorMail = new Zend_Validate_EmailAddress(Zend_Validate_Hostname::ALLOW_DNS, false, $validatorHostname);
        $validatorMail->setMessages(array(
            Zend_Validate_EmailAddress::INVALID => "'%value%' is not a valid email address",
            Zend_Validate_EmailAddress::INVALID_HOSTNAME => "'%hostname%' is not a valid hostname for email address '%value%'",
            Zend_Validate_EmailAddress::INVALID_MX_RECORD => "'%hostname%' does not appear to have a valid MX record for the email address '%value%'",
            Zend_Validate_EmailAddress::DOT_ATOM => "'%localPart%' not matched against dot-atom format",
            Zend_Validate_EmailAddress::QUOTED_STRING => "'%localPart%' not matched against quoted-string format",
            Zend_Validate_EmailAddress::INVALID_LOCAL_PART => "'%localPart%' is not a valid local part for email address '%value%'"
        ));
        $mail->setRequired(true)->setLabel('Mail: ')
                ->addValidator($validatorNotEmpty)
                ->addValidator($validatorMail);
        $mail->addDecorators(array(
            array('Errors'),
        ));
        $this->addElement($mail);
        
        $haslo = new Zend_Form_Element_Password('Haslo');
        $validatorHasloStringLength = new Zend_Validate_StringLength(8,20);
        $validatorHasloStringLength->setMessages(array(
            Zend_Validate_StringLength::TOO_SHORT => 'Imie nie moze byc krotsze niz 8 znaków.',
            Zend_Validate_StringLength::TOO_LONG  => 'Imie nie moze byc dluzsze niz 20 znaki.'
        ));
        $haslo->setRequired(true)->setLabel('Hasło: ')
                ->addValidator($validatorNotEmpty)
                ->addValidator($validatorHasloStringLength);
        $haslo->addDecorators(array(
            array('Errors'),
        ));
        $this->addElement($haslo);
        
        $powtorzHaslo = new Zend_Form_Element_Password('PowtorzHaslo');
        $validatorIdenticalHaslo = new Zend_Validate_Identical('Haslo');
        $validatorIdenticalHaslo->setMessage('Hasła nie są identyczne');
        $powtorzHaslo->setRequired(true)->setLabel('Powtórz hasło: ')
                ->addValidator($validatorNotEmpty)
                ->addValidator($validatorIdenticalHaslo);
        $powtorzHaslo->addDecorators(array(
            array('Errors'),
        ));
        $this->addElement($powtorzHaslo);
        
        $validatorAlnum = new Zend_Validate_Alnum();
        $validatorAlnum->setMessage('Dopuszczalne sa wylacznie znaki alfanumeryczne');
        $validatorImieStringLength = new Zend_Validate_StringLength(3,32);
        $validatorImieStringLength->setMessages(array(
            Zend_Validate_StringLength::TOO_SHORT => 'Imie nie moze byc krotsze niz 3 znaki.',
            Zend_Validate_StringLength::TOO_LONG  => 'Imie nie moze byc dluzsze niz 32 znaki.'
        ));
        $imie = new Zend_Form_Element_Text('Imie');
        $imie->setRequired(true)->setLabel('Imie: ')
                ->addFilter($filterTrim)
                ->addValidator($validatorNotEmpty)
                ->addValidator($validatorAlnum)
                ->addValidator($validatorImieStringLength);
        $imie->addDecorators(array(
            array('Errors'),
        ));
        $this->addElement($imie);

        $validatorNazwiskoStringLength = new Zend_Validate_StringLength(2,40);
        $validatorNazwiskoStringLength->setMessages(array(
            Zend_Validate_StringLength::TOO_SHORT => 'Nazwisko nie moze byc krotsze niz 2 znaki.',
            Zend_Validate_StringLength::TOO_LONG  => 'Nazwisko nie moze byc dluzsze niz 40 znaków.'
        ));
        $nazwisko = new Zend_Form_Element_Text('Nazwisko');
        $nazwisko->setRequired(true)->setLabel('Nazwisko: ')
                ->addFilter($filterTrim)
                ->addValidator($validatorNotEmpty)
                ->addValidator($validatorAlnum)
                ->addValidator($validatorNazwiskoStringLength);
        $imie->addDecorators(array(
            array('Errors'),
        ));
        $this->addElement($nazwisko);
        
        $this->addElement('text', 'telefon', array('label' => 'Nr Telefonu: '));
        $this->addElement('text', 'data_urodzenia', array('label' => 'Data Urodzenia: '));
        
        $this->addElement('submit', 'register', array('label' => 'Zarejestruj sie!'));
    }


}

