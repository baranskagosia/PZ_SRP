<?php

class Application_Form_NewUser extends Zend_Form
{

    public function init()
    {
       $this->setMethod('post');
       $ValidatorAdresMail= new Zend_Validate_EmailAddress();
       $ValidatorAdresMail->setOptions(array('deep'  => true,  'domain'    => true,));
  
       
       $login =new Zend_Form_Element_Text('Nazwa');
       $login->setLabel('Adres email (Login):')
               ->setRequired()
               ->addValidator( 'NotEmpty',true,array('messages'=>'Login nie może być pusty'))
               ->addValidator($ValidatorAdresMail); //EmailAdress


       $password= new Zend_Form_Element_Password('Haslo');
       $password->setLabel('Hasło: ')
                ->setRequired(true)
                ->addValidator( 'NotEmpty',true,array('messages'=>'Hasło nie może być puste'))
                ->addValidator('Alnum');

      $options= array('recepcja'=>'recepcja','admin'=>'admin');
      $role = new Zend_Form_Element_Select('Role');
      $role ->setLabel('Rola:')
                    ->addMultiOptions($options);
      
      
      $zapis = new Zend_Form_Element_Submit('Zapis');
      $zapis ->setLabel('Zapisz');


       $this->addElements(array( $login, $password, $role,$zapis));



    }

}

