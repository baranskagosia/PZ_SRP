<?php

class Application_Form_Admin_EditLanes extends Zend_Form
{
    public function init()
    {
        $optionsArray = array();
        for($i=1; $i<=30; $i++)
            $optionsArray["$i"] = "$i";
        
        $this->setAction("update-tor")->setMethod('post');
        
        
        
        $db = Zend_Db_Table::getDefaultAdapter();
        $query_string = "SELECT COUNT(*) AS lanesCount FROM tor";
        $result = $db->query($query_string)->fetch();
        $lanesCount = $result['lanesCount'];
        
        $lanesNoSelector = new Zend_Form_Element_Select("LiczbaTorow");
        $lanesNoSelector->setLabel("Liczba torów: ");
        $lanesNoSelector->setMultiOptions($optionsArray);
        $lanesNoSelector->setValue($lanesCount);
        $this->addElement($lanesNoSelector);
        
        $this->addElement('submit', 'confirm', array('label' => 'Zatwierdź zmiany'));
    }


}

