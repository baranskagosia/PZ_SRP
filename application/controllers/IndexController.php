<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
         	/*
            $db=Zend_Db_Table_Abstract::getDefaultAdapter();
            $sql="SELECT * FROM aktualnosci WHERE czyAktualne LIKE 1";
            $wynik=$db-> query($sql)->fetchAll();
            $this->view->wynik=$wynik;
			*/
    }

    public function onasAction()
    {
        // action body
    }

    public function galeriaAction()
    {
       
    }

    public function kontaktAction()
    {
        // action body
    }

    public function cennikAction()
    {
         
         
         
         
    
    }

    public function rezerwacjaAction()
    {
        // action body
    }

    public function grafikAction()
    {
        $DbTable = new Application_Model_Info();
        $iloscTorow = $DbTable->IloscTorow();
        $this->view->iloscTorow = $iloscTorow;
        
     
    }

    public function logowanieAction()
    {
        // action body
    }

    public function kalendarzAction()
    {
        // action body
    }


}















