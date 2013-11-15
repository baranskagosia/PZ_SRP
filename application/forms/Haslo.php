<?php

class Application_Form_Haslo extends Zend_Form
{

    /*public function __construct($option =null)
    {
       parent::__construct($option);
	 * 
	 */

	 public function init()
{
       /**$Haslo_old =new Zend_Form_Element_Password('Haslo_old');
       $Haslo_old->setLabel('Stare hasło:')
               ->setRequired('true')
			   ->addValidator( 'NotEmpty',true,array('messages'=>'Hasło nie może być puste'))
               ->addValidator('Alnum');
			   ;
		**/
		
       $Haslo_new1 = new Zend_Form_Element_Password('Haslo_new1');
       $Haslo_new1-> setLabel('Nowe hasło: ')
               ->setRequired('true')->addValidator( 'NotEmpty',true,array('messages'=>'Hasło nie może być puste'))
               ->addValidator('Alnum');
			   ;
			   
			   
       $Haslo_new2 = new Zend_Form_Element_Password('Haslo_new2');
       $Haslo_new2-> setLabel('Powtórz nowe hasło: ')
               ->setRequired('true')
               ->addValidator( 'NotEmpty',true,array('messages'=>'Hasło nie może być puste'))
               ->addValidator('Alnum');
			   ;
			   
		   $Zmien = new Zend_Form_Element_Submit('Zmień hasło');
	       $Zmien ->setLabel('Zmień hasło');
		
       $this->addElements(array($Haslo_new1, $Haslo_new2, $Zmien));
      $this->setMethod('post');
	   
	   }


}

