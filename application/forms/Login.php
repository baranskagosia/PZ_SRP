<?php

class Application_Form_Login extends Zend_Form
{

    public function __construct($option =null)
    {
       parent::__construct($option);
        
       $this->setName('login');
        $ValidatorAdresMail= new Zend_Validate_EmailAddress();
        $ValidatorAdresMail->setOptions(array('deep'  => true,  'domain'    => true,));

       $Nazwa =new Zend_Form_Element_Text('Nazwa');
       $Nazwa->setLabel('Adres email (Login):')
               ->setRequired()
               ->addValidator( 'NotEmpty',true,array('messages'=>'Login nie może być pusty'))
               ->addValidator($ValidatorAdresMail); //EmailAdress

       $Haslo = new Zend_Form_Element_Password('Haslo');
       $Haslo-> setLabel('Hasło: ')
               ->setRequired('true')
               ->addValidator( 'NotEmpty',true,array('messages'=>'Hasło nie może być puste'))
               ->addValidator('Alnum');

       $Zaloguj = new Zend_Form_Element_Submit('Zaloguj');
       $Zaloguj ->setLabel('Zaloguj');


       $this->addElements(array( $Nazwa, $Haslo,  $Zaloguj));
       $this->setMethod('post');



    }


}

