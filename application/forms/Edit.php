<?php

class Application_Form_Edit extends Zend_Form
{
	/**private $i;
	private $n;
	private $t;
	
	public function __construct($i, $n, $t)
   {
   		var_dump($this);	
      $this->Imie = $i;
	  $this->Nazwisko = $n;
	  $this->Telefon = $t;
	  
      //It is required to call the parent contructor, else the form will not work
      parent::__construct();
    }
   **/
   
	 public function init()
{
	   $Imie = new Zend_Form_Element_Text('Imie');
       $Imie-> setLabel('Podaj imie: ')
	   ->setRequired('true')->addValidator( 'NotEmpty',true,array('messages'=>'Imię nie może być puste'))
	   ->addValidator('Alnum')
	   ;	   
			   
       $Nazwisko = new Zend_Form_Element_Text('Nazwisko');
       $Nazwisko-> setLabel('Podaj nazwisko: ')->setRequired('true')->addValidator( 'NotEmpty',true,array('messages'=>'Nazwisko nie może być puste'))
	   ;
	   
	   $Telefon = new Zend_Form_Element_Text('Telefon');
       $Telefon-> setLabel('Podaj telefon: ')->setRequired('true')
	   ->addValidator('Digits',true,array('messages'=>'Telefon musi składać się z cyfr'))
	   ->addValidator('StringLength',true,array(0,9,'messages'=>'Telefon nie może mieć więcej niż 9 cyfr'))
			   
               ;
			   
			   
			   
		$Zmien = new Zend_Form_Element_Submit('Zmień');
	    $Zmien ->setLabel('Zmień');
		
       $this->addElements(array($Imie, $Nazwisko, $Telefon, $Zmien));
      $this->setMethod('post');
	   
	   }


}

