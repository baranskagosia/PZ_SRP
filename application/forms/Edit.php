<?php

class Application_Form_Edit extends Zend_Form
{

	 public function init()
{

       $Imie = new Zend_Form_Element_Text('Imie');
       $Imie-> setLabel('Podaj imie: ');
			   
			   
       $Nazwisko = new Zend_Form_Element_Text('Nazwisko');
       $Nazwisko-> setLabel('Podaj nazwisko: ')
               ;
	
	   $Telefon = new Zend_Form_Element_Text('Telefon');
       $Telefon-> setLabel('Podaj telefon: ')
               ;
			   
			   
			   
		$Zmien = new Zend_Form_Element_Submit('Zmień');
	    $Zmien ->setLabel('Zmień');
		
       $this->addElements(array($Imie, $Nazwisko, $Telefon, $Zmien));
      $this->setMethod('post');
	   
	   }


}

