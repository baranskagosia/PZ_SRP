<?php

class Application_Model_Klient extends Zend_Db_Table_Abstract
{
 public function klientIDUzytkownik($userID){
     if(!empty($userID))
        $sql='CALL klientIDUzytkownik(?)';
        $where = $this->getAdapter()->quoteInto($sql,$userID);
        $ilosc =$this-> getAdapter()-> query($where);
     return IDKlient;
 }

}

