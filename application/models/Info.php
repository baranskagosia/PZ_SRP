<?php

class Application_Model_Info extends Zend_Db_Table_Abstract
{
    public function Cennik() {
        $sql='CALL Cennik_Wyswietl';
        $cennik = $this->getAdapter()-> query($sql)->fetchAll();
     return $cennik;
}

    public function IloscTorow() {
        $sql='SELECT MAX(NumerToru) AS Ilosc_Torow FROM tor';
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
 
 public function DzienTygodnia($DzienTygodnia){
        switch($DzienTygodnia){
           case 1: {
               $dzien='poniedziałek';
               break;
           }
           case 2:{
               $dzien='wtorek';
               break;
           }
           case 3:{
               $dzien='sroda';
               break;
           }
           case 4: {
               $dzien='czwartek';
               break;
           }
           case 5:{
               $dzien='piatek';
               break;
           }
               
           case 6:{
               $dzien='sobota';
                break;}
           
       }
       return $dzien;
    }

       
}

