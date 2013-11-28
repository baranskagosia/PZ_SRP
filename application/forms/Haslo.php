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
	   $Haslo_stare = new Zend_Form_Element_Password('Haslo_stare');
       $Haslo_stare->setLabel('Stare hasło:')
               ->setRequired('true');
		
       $Haslo_new1 = new Zend_Form_Element_Password('Haslo_new1');
       $Haslo_new1-> setLabel('Nowe hasło: ')
               ->setRequired('true')->addValidator( 'NotEmpty',true,array('messages'=>'Hasło nie może być puste'))
			   ->addValidator('Alnum')
			   ->addValidator('Identical', true, array('token'=>'Haslo_new2','messages'=>'Hasła się nie zgadzają!'))
			   ->addValidator('StringLength',true,array(8,20,'messages'=>'Hasło musi mieć mininum 8 znaków'));
			   ;
			   
			   
       $Haslo_new2 = new Zend_Form_Element_Password('Haslo_new2');
       $Haslo_new2-> setLabel('Powtórz nowe hasło: ')
               ->setRequired('true')
               ->addValidator('NotEmpty',true,array('messages'=>'Hasło nie może być puste'))
               ->addValidator('Alnum')
			   ->addValidator('Identical', true, array('token'=>'Haslo_new1','messages'=>'Hasła się nie zgadzają!'))
			   ->addValidator('StringLength',true,array(8,20,'messages'=>'Hasło musi mieć mininum 8 znaków'));
			   ;
			   
	   $Zmien = new Zend_Form_Element_Submit('Zmień hasło');
       $Zmien ->setLabel('Zmień hasło');
		
       $this->addElements(array($Haslo_stare, $Haslo_new1, $Haslo_new2, $Zmien));
       $this->setMethod('post');
	   
	   }


}

