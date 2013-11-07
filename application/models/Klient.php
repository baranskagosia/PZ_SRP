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

    public function add($imie, $nazwisko, $idUzytkownik) {
        $idKlienta = null;
        if (!(empty($imie) || empty($nazwisko) || empty($idUzytkownik))) {
            $newKlient = array(
                'Imie' => $imie,
                'Nazwisko' => $nazwisko,
                'idUzytkownik' => $idUzytkownik
            );

            $idKlienta = $this->insert($newKlient);
        }

        return $idKlienta;
    }

}

