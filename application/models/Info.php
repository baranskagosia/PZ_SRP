<?php

class Application_Model_Info extends Zend_Db_Table_Abstract
{
    public function Cennik() {
        $sql='CALL Cennik_Wyswietl';
        $cennik = $this->getAdapter()-> query($sql)->fetchAll();
     return $cennik;
}

    public function IloscTorow() {
        $sql='SELECT MAX(NumerToru) AS Ilosc_Torow FROM Tor';
        $ileTorow = $this->getAdapter()-> query($sql)->fetchAll();
     return $ileTorow;
}
    public function GodzinyOtwarcia($DzienTygodnia){
     if(!empty($DzienTygodnia))
        $sql='CALL GodzinyOtwarcia(?)';
        $where = $this->getAdapter()->quoteInto($sql,$DzienTygodnia);
        $otwarty =$this-> getAdapter()-> query($where);
     return $otwarty;
 }
}

