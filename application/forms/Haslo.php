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
			   ->addValidator('Alnum')
			   ->addValidator('Identical', true, array('token'=>'Haslo_new2','messages'=>'Hasła się nie zgadzają!'))
			   ->addValidator('StringLength',true,array(4,16,'messages'=>'Hasło musi mieć mininum 4 znaki'));
			   ;
			   
			   
       $Haslo_new2 = new Zend_Form_Element_Password('Haslo_new2');
       $Haslo_new2-> setLabel('Powtórz nowe hasło: ')
               ->setRequired('true')
               ->addValidator('NotEmpty',true,array('messages'=>'Hasło nie może być puste'))
               ->addValidator('Alnum')
			   ->addValidator('Identical', true, array('token'=>'Haslo_new1','messages'=>'Hasła się nie zgadzają!'))
			   ->addValidator('StringLength',true,array(4,16,'messages'=>'Hasło musi mieć mininum 4 znaki'));
			   ;
			   
		   $Zmien = new Zend_Form_Element_Submit('Zmień hasło');
	       $Zmien ->setLabel('Zmień hasło');
		
      $this->addElements(array($Haslo_new1, $Haslo_new2, $Zmien));
      $this->setMethod('post');
	   
	   }


}

