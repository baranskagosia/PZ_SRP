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
        $query = $this->select()->where("idAktualnosci = ?", $id);
        
        return $db->query($query)->fetch();
    }
    
    public function aktualizujAktualnosc($id, $naglowek, $tresc)
    {
        $aktualnosc = array(
            'naglowek'  => $naglowek,
            'tresc'     => $tresc
        );
        
        $where = $this->getAdapter()->quoteInto('idAktualnosci = ?', $id);
        
        return $this->update($aktualnosc, $where);
    }
    
    public function dodajAktualnosc($naglowek, $tresc)
    {
        $idAktualnosc = null;
        
        if(!(empty($naglowek) || empty($tresc))) {
            $newAktualnosc = array(
                'naglowek'      => $naglowek,
                'tresc'         => $tresc,
                'czyAktualne'   => 1
            );
            
            $idAktualnosc = $this->insert($newAktualnosc);
        }
        
        return $idAktualnosc;
    }
}
?>
