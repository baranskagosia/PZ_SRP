<script type="text/javascript">

var kwota = 0;

function cena(){
	console.log;
	//if (document.getElementById("OsobaTyp").Osoba[0].checked == true) {
    // dziecko
    if(document.getElementById("Osoba-Dziecko").checked == true){
    	kwota = 10;
    	var ile = document.getElementById("IleRezerwacji").value;
    	document.getElementById("Cena").value = kwota*ile;
    }
	else {
    	if (document.getElementById("Osoba-Student").checked == true){
        // student
        kwota = 15;
    	var ile = document.getElementById("IleRezerwacji").value;
        document.getElementById("Cena").value = kwota*ile;
    	}
    	else {
        // dorosly
        kwota = 20;
    	var ile = document.getElementById("IleRezerwacji").value;
        document.getElementById("Cena").value = kwota*ile;
    	}
	}
	//alert(kwota);
}

</script>
<?php

class Application_Form_Rezerwacja extends Zend_Form
{

    public function init()
    {
        $kwota = 0;
		
        $this->setMethod('post');
        $czasOd=new Zend_Form_Element_Text('Poczatek');
        $czasOd->setAttribs(array('readonly' => 'true'))
                ->setLabel('Poczatek: ');
             
        
          
        $ileRezerwacji= new Zend_Form_Element_Select('IleRezerwacji');
        $ileRezerwacji->setLabel('Czas trwania')
                       ->setRequired(true)
                       ->setMultiOptions(array("1"=>"1"));
        
               //->setMultiOptions(array("1"=>"1", "2"=>"2"));
                


        $tor=new Zend_Form_Element_Text('TorPreferowany');
        $tor->setAttribs(array('readonly' => 'true'))
               ->setLabel('Tor: ');
        
      
       $wylacznosc= new Zend_Form_Element_Checkbox('CzyNaWylacznosc');
       $wylacznosc ->setLabel('Czy tor na wyłączność: ');
         
       $OsobaTyp= new Zend_Form_Element_Radio('OsobaTyp');
       $OsobaTyp ->setLabel('Typ osoby: ')
                 ->setmultiOptions(array( "Dziecko"=>"Dziecko", "Student"=>"Student", "Dorosły"=>"Dorosły"))
                ->setValue("Dorosły")
				->setName('Osoba')
				->setAttrib('onclick', 'cena()');
       
	   	
        $cena=new Zend_Form_Element_Text('Cena');
        $cena ->setAttribs(array('disable' => 'disable'))
        ->setLabel('Cena: ')
		->setValue($kwota);
      
        $dataCzas=new Zend_Form_Element_Hidden('DataCzas');
        $iloscOsob=new Zend_Form_Element_Hidden('IloscOsob');
        $czyOdwolana=new Zend_Form_Element_Hidden('CzyOdwolana');
        $czasTrwania=new Zend_Form_Element_Hidden('CzasTrwania');
        $idUzytkownik=new Zend_Form_Element_Hidden('uzytkownik_idUzytkownik');
        
		
       
       $zapis = new Zend_Form_Element_Submit('Add');
       $zapis ->setLabel('Rezerwuj');

     
       //$IDKlient=$this->getView()->getHelper('LoggedInAs')->loggedInAs();

    
           $this->addElements(array($czasOd,$tor,$wylacznosc,$ileRezerwacji,$OsobaTyp,$cena,$zapis,$dataCzas,$iloscOsob,$czyOdwolana,$czasTrwania,$idUzytkownik));
               //$ileRezerwacji $czasTrwania$OsobaTyp, $dataCzas,$zapis));
    }


}

