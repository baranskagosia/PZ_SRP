<?php

class Application_Model_Klient extends Zend_Db_Table_Abstract {

    protected $_name = 'klient';

    public function klientIDUzytkownik($userID) {
        if (!empty($userID))
            $sql = 'CALL klientIDUzytkownik(?)';
        $where = $this->getAdapter()->quoteInto($sql, $userID);
        $ID = $this->getAdapter()->query($where);
        return $ID;
    }

    public function klientDane($idKlient) {
        if (!empty($idKlient))
            $sql = 'CALL klientDane(?)';
        $where = $this->getAdapter()->quoteInto($sql, $idKlient);
        $dane = $this->getAdapter()->query($where);
        return $dane;
    }

    public function add($imie, $nazwisko, $telefon ,$data, $idUzytkownik) {
        $idKlienta = null;
        if (!(empty($imie) || empty($nazwisko) || empty($idUzytkownik))) {
            $newKlient = array(
                'Imie' => $imie,
                'Nazwisko' => $nazwisko,
                'Telefon' => $telefon,
                'DataUrodzenia' => $data,
                'idUzytkownik' => $idUzytkownik
            );

            $idKlienta = $this->insert($newKlient);
        }

        
        return $idKlienta;
    }
 public function getNextAutoIncrementValue() {
        $db = $this->getAdapter();
        $sql = "SHOW TABLE STATUS LIKE 'klient'";
        
        $klientTableStatus = $db->query($sql)->fetch();
        
        return $klientTableStatus['Auto_increment'];
    }

 }