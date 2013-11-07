<?php

class Application_Form_Rezerwacja extends Zend_Form
{

    public function init()
    {
         $this->setAction('rezerwacja-zapisz');
         
        $czasOd=new Zend_Form_Element_Text('Poczatek');
        $czasOd->setAttribs(array('disable' => 'disable'))
                ->setLabel('Poczatek: ');
                

        $czasTrwania= new Zend_Form_Element_Select('CzasTrwania');
        $czasTrwania->setLabel('Czas trwania');
                
       
        $czasDo=new Zend_Form_Element_Text('Koniec');
        $czasDo->setAttribs(array('disable' => 'disable'))
                ->setLabel('Koniec: ');


        $tor=new Zend_Form_Element_Text('Tor');
        $tor ->setAttribs(array('disable' => 'disable'))
                ->setLabel('Tor: ');
        
       
       $wylacznosc= new Zend_Form_Element_Checkbox('Wylacznosc');
       $wylacznosc ->setLabel('Czy tor na wyłączność: ');
        
       $OsobaTyp= new Zend_Form_Element_Radio('OsobaTyp ');
       $OsobaTyp ->setLabel('Typ osoby: ')
               ->setmultiOptions(array( "Dziecko"=>"Dziecko", "Student"=>"Student", "Dorosły"=>"Dorosły"));
               //->setOptions(array( "Dziecko"=>"Dziecko", "Student"=>"Student", "Dorosły"=>"Dorosły"));
                //->setmultiOptions(array( "Dziecko"=>"Dziecko", "Student"=>"Student", "Dorosły"=>"Dorosły",));
       
        $cena=new Zend_Form_Element_Text('Cena');
        $cena ->setAttribs(array('disable' => 'disable'))
                ->setLabel('Cena: ');
        
       $zapis = new Zend_Form_Element_Submit('Rezewuj');
       $zapis ->setLabel('Rezerwuj');

       //$IDKlient=$this->getView()->getHelper('LoggedInAs')->loggedInAs();

    
           $this->addElements(array($czasOd,$czasTrwania,$tor,$wylacznosc,$OsobaTyp,$zapis));
    }


}

