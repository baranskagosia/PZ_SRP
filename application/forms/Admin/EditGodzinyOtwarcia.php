<?php

class Application_Form_Admin_EditGodzinyOtwarcia extends Zend_Form
{
    public function init()
    {
        $optionsArray = array();
        for($i=0; $i<=23; $i++) {
            $input_name = ($i<10 ? "0" : "") . $i . ":00:00";
            $optionsArray[$input_name] = "$input_name";
        }
        
        $url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        $tmp = explode('/', $url);
        if(count($tmp) > 7) {
        $id=$tmp[7];
        
        $db = Zend_Db_Table::getDefaultAdapter();
        $sqlstr = "SELECT * FROM godziny_otwarcia WHERE idGodzinyOtwarcia = ?";
        $dzienTygodnia = $db->query($sqlstr, $id)->fetch();
        
        if(!is_null($dzienTygodnia['GodzinaOtwarcia'])) {
        
        
        $this->setAction("../update-godziny-otwarcia/" . $id)->setMethod('post');
               
        $godzinaOtwarcia = new Zend_Form_Element_Select("GodzinaOtwarcia");
        $godzinaOtwarcia->setLabel("Godzina otwarcia: ")
                ->setMultiOptions($optionsArray)
                ->setValue($dzienTygodnia['GodzinaOtwarcia']);
        $this->addElement($godzinaOtwarcia);
        
        $godzinaZamkniecia = new Zend_Form_Element_Select("GodzinaZamkniecia");
        $godzinaZamkniecia->setLabel("Godzina zamknięcia: ")
                ->setMultiOptions($optionsArray)
                ->setValue($dzienTygodnia['GodzinaZamkniecia']);
        $this->addElement($godzinaZamkniecia);
        
        $this->addElement('submit', 'confirm', array('label' => 'Zatwierdź zmiany'));
        }} else {
            
        }
    }


}

