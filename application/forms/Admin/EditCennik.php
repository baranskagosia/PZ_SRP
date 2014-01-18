<?php

class Application_Form_Admin_EditCennik extends Zend_Form
{
    public function init()
    {
        $this->setAction("update-cennik")->setMethod('post');
        
        $db = Zend_Db_Table::getDefaultAdapter();
        $sqlstr = "SELECT * FROM cennik";
        $cennik = $db->query($sqlstr)->fetchAll();
        
        $validatorBetween = new Zend_Validate_Between(array('min' => 1, 'max' => 1000));
        $validatorBetween->setMessage('Dopuszczalne sa wylacznie liczby z zakresu od 1 do 1000');
        
        $validatorNotEmpty = new Zend_Validate_NotEmpty();
        $validatorNotEmpty->setMessage('To pole jest wymagane.');
        
        foreach ($cennik as $row) {
            $curr = new Zend_Form_Element_Text($row['idCennik']);
            $curr->setLabel($row['Taryfa']);
            $curr->addValidator($validatorNotEmpty);
            $curr->addValidator($validatorBetween);
            $curr->setValue($row['Cena']);
            
            $this->addElement($curr);
        }
        
        $this->addElement('submit', 'confirm', array('label' => 'Zatwierdź zmiany'));
    }


}

