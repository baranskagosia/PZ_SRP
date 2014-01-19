<?php

class Application_Model_Aktualnosci extends Zend_Db_Table_Abstract
{
    protected $_name = 'aktualnosci';
    
    public function wszystkieAktualnosci()
    {
        $db = $this->getAdapter();
        $sql = "SELECT * FROM aktualnosci";
        $query = $db->query($sql);
        
        return $query->fetchAll();
    }
    
    public function pobierzAktualnoscPoId($id)
    {
        $db = $this->getAdapter();
        $query = "SELECT * FROM aktualnosci WHERE idAktualnosci = ?";
        return $db->query($query, $id)->fetch();
    }
    
    public function aktualizujAktualnosc($id, $naglowek, $tresc, $data, $czyAktualne)
    {
        if(!(empty($id) || empty($naglowek) || empty($tresc) || empty($data))) {
            $aktualnosc = array(
                'naglowek'  => $naglowek,
                'tresc'     => $tresc,
                'Data'      => $data,
                'czyAktualne' => $czyAktualne
            );
        
            $where = $this->getAdapter()->quoteInto('idAktualnosci = ?', $id);
        
            return $this->update($aktualnosc, $where);
        }
        
        return null;
    }
    
    public function dodajAktualnosc($naglowek, $tresc, $data, $czyAktualne)
    {
        $idAktualnosc = null;
        
        if(!(empty($naglowek) || empty($tresc) || empty($data))) {
            $newAktualnosc = array(
                'naglowek'      => $naglowek,
                'tresc'         => $tresc,
                'Data'          => $data,
                'czyAktualne'   => $czyAktualne
            );
            
            $idAktualnosc = $this->insert($newAktualnosc);
        }
        
        return $idAktualnosc;
    }
}
?>
