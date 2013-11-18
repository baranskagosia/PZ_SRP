<?php

class Application_Model_Users extends Zend_Db_Table_Abstract
{

 public function addNewUser($Login, $Haslo, $Rola) {
      if(!empty($Login) && !empty($Haslo) && !empty($Rola))
        $sql='CALL addNewUser(?, ?, ?)';
        $replacements = array($Login, $Haslo, $Rola);
        $user =$this->getAdapter()-> query($sql,$replacements);
     return $user;
}

public function addNewCustomer($Login, $Haslo, $Rola) {
      if(!empty($Login) && !empty($Haslo) && !empty($Rola))
        $sql='CALL addNewCustomerAdmin(?, ?, ?)';
        $replacements = array($Login, $Haslo, $Rola);
        $user =$this->getAdapter()-> query($sql,$replacements);
     return $user;
}

 public function IsUniqueMail($Mail){
     if(!empty($Mail))
        $sql='CALL IsUniqueMail(?)';
        $where = $this->getAdapter()->quoteInto($sql,$Mail);
        $ilosc =$this-> getAdapter()-> query($where);
     return $ilosc;
 }
 
 public function getNextAutoIncrementValue() {
        $db = $this->getAdapter();
        $sql = "SHOW TABLE STATUS LIKE 'uzytkownik'";
        
        $uzytkownikTableStatus = $db->query($sql)->fetch();
        
        return $uzytkownikTableStatus['Auto_increment'];
    }
 
}

