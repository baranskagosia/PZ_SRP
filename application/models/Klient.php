<?php

class Application_Model_Klient extends Zend_Db_Table_Abstract
{
 public function klientIDUzytkownik($userID){
     if(!empty($userID))
        $sql='CALL klientIDUzytkownik(?)';
        $where = $this->getAdapter()->quoteInto($sql,$userID);
        $ID =$this-> getAdapter()-> query($where);
     return $ID;
 }

 public function klientDane($idKlient){
     if(!empty($idKlient))
        $sql='CALL klientDane(?)';
        $where = $this->getAdapter()->quoteInto($sql,$idKlient);
        $dane =$this-> getAdapter()-> query($where);
     return $dane;
 }
 
}

