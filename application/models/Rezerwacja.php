<?php

class Application_Model_Rezerwacja extends Zend_Db_Table_Abstract
{
    protected $_name = 'rezerwacja';
    
public function Zajete($data_time, $tor) {
        $sql="SELECT Distinct(`DataCzas`) AS unikalne, TIME(DataCzas) AS Godzina, Date(DataCzas) AS Data, 
               `TorPreferowany` ,  `CzyNaWylacznasc`, count(*) AS ZarezerwowaneMiejsca
              FROM rezerwacja WHERE DataCzas LIKE '".$data_time."' AND
                    TorPreferowany =".$tor." AND`CzyOdwolana` =0 
               GROUP BY DataCzas";
        $zajete = $this->getAdapter()-> query($sql)->fetchAll();
     return $zajete;
}


public function Dodawanie($DataCzas, $TorPreferowany, $IloscOsob, $CzyNaWylacznosc, 
        $CzyOdwolana, $CzasTrwania, $IDUzytkownik, $Cena){
    if(!empty($DataCzas)&& !empty($TorPreferowany)&& !empty($IloscOsob) && !empty($CzyNaWylacznosc)
        && !empty($CzyOdwolana) && !empty($CzasTrwania) && !empty($IDUzytkownik)&& !empty($Cena)){
        $sql="CALL Rezerwacja_Indywidualna_Dodawanie('".$DataCzas."','".$TorPreferowany."',
            '".$IloscOsob."','".$CzyNaWylacznosc."','".$CzyOdwolana."','".$CzasTrwania."',
                '".$IDUzytkownik."','".$Cena."')";

        $dodawanie = $this->getAdapter()-> query($sql);
     return $dodawanie;
        }
        }

}

