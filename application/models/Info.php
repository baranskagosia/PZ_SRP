<?php

class Application_Model_Info extends Zend_Db_Table_Abstract
{
    public function Cennik() {
        $sql='CALL Cennik_Wyswietl';
        $cennik = $this->getAdapter()-> query($sql)->fetchAll();
     return $cennik;
}

}

