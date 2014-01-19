<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
         	
            $db=Zend_Db_Table_Abstract::getDefaultAdapter();
            $sql="SELECT * FROM aktualnosci WHERE czyAktualne LIKE 1 ORDER BY Data DESC LIMIT 5";
            $wynik=$db-> query($sql)->fetchAll();
            $this->view->wynik=$wynik;
			
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
        $db=Zend_Db_Table_Abstract::getDefaultAdapter();
        $helper= $this->view->getHelper('LoggedInAs');
        $IDKlient=$helper->loggedInAs();
        if(isset($IDKlient)){
             $idUSER="SELECT idUzytkownik FROM klient WHERE idKlient=$IDKlient";
             $ID=$db->query($idUSER)->fetchAll();
    
             $IDUzytkownik=$ID[0]['idUzytkownik'];
        }
       else{
           $IDUzytkownik=null;  
       }
     $this->view->IDUzytkownik=$IDUzytkownik;
    
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
        $db=Zend_Db_Table_Abstract::getDefaultAdapter();
        $helper= $this->view->getHelper('LoggedInAs');
        $IDKlient=$helper->loggedInAs();
        if(isset($IDKlient)){
             $idUSER="SELECT idUzytkownik FROM klient WHERE idKlient=$IDKlient";
             $ID=$db->query($idUSER)->fetchAll();
    
             $IDUzytkownik=$ID[0]['idUzytkownik'];
        }
       else{
           $IDUzytkownik=null;  
       }
     $this->view->IDUzytkownik=$IDUzytkownik;
    }

    public function rejestracjaAction()     {
        $usersModel = new Application_Model_Users();
        $klientModel = new Application_Model_Klient();
        $registrationForm = new Application_Form_NewKlient();
        $this->view->registrationForm = null;
        
        if($this->getRequest()->isPost()) {
            if($registrationForm->isValid($_POST)) {
                $values = $registrationForm->getValues();
                
                $db = Zend_Db_Table::getDefaultAdapter();
                $dataArray = explode(".", $values['DataUrodzenia']);
                $dataUSformat = empty($values['DataUrodzenia']) ? null : $dataArray[2]."-".$dataArray[1]."-".$dataArray[0];
                try {
                    $db->beginTransaction();
                    
                    $userId = $usersModel->getNextAutoIncrementValue();
                    $user = $usersModel->addNewUser($values['Mail'], md5($values['Haslo']), 'klient');
                    
                    $klientId = $klientModel->add($values['Imie'], $values['Nazwisko'], $values['Telefon'],$dataUSformat, $userId);
                    
                    $db->commit();
                } catch(Zend_Db_Statement_Exception $e) {
                    $db->rollback();
                    throw $e;
                    //TODO: sprawdzenie warunków, przy których może wystąpić
                    // "wyścig"
                }
                
                $this->view->idUzytkownik = $usersModel->getNextAutoIncrementValue();
            }
            else {
                $this->view->registrationForm = $registrationForm;
            }
        }
        else {
                $this->view->registrationForm = $registrationForm;
        }
    }

}
















