<?php

class AdminController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }


    public function indexAction()
    {
        // action body
    }

    public function newRecepcjaAction()
    {
        $request =$this ->getRequest();
       $db=Zend_Db_Table_Abstract::getDefaultAdapter();
        $DbTable=new Application_Model_Users();
  
        
        $formUzytkownik= new Application_Form_NewUser();
 
        if ($request->isPost()
            && $formUzytkownik->isValid($request->getPost()) ){
                    $addArray=$formUzytkownik->getValues();
                    $Login=$addArray['Nazwa'];
                    $Haslo=md5($addArray['Haslo']);
                    $Rola=$addArray['Role'];
                    
                    $isUniqueMail= $DbTable->IsUniqueMail($Login)->fetchAll();
                    
                    if($isUniqueMail[0]['ilosc']>0){
                        $message='Podany mail znajduje się już w bazie danych.';
                        $this->view->message= $message;
                    }
                    else{
                       
                        $DbTable->addNewUser($Login, $Haslo, $Rola);
                        $this->_redirect('/admin/new-recepcja-zapisz');
                        
                        }
                    
                    }
        
     $this->view->Uzytkownik= $formUzytkownik;
 

    }

    public function newKlientAction()
    {
        // action body
    }

    public function newRecepcjaZapiszAction()
    {
        // action body
    }

    public function newKlientZapiszAction()
    {
        // action body
    }
    
    public function editTorAction()
    {
        $editLanesForm = new Application_Form_Admin_EditLanes();
        $this->view->editLanesForm = $editLanesForm;
    }
    
    public function updateTorAction()
    {
        $editLanesForm = new Application_Form_Admin_EditLanes();
        if($this->getRequest()->isPost()) {
            if($editLanesForm->isValid($_POST)) {
                $values = $editLanesForm->getValues();
                $db = Zend_Db_Table_Abstract::getDefaultAdapter();
                $sqlstr = "DELETE FROM tor";
                $query = $db->query($sqlstr);
                
                for($i=1; $i<=$values["LiczbaTorow"]; $i++) {
                        $sqlstr = "INSERT INTO tor VALUES (?, ?)";
                        $query = $db->query($sqlstr, array($i, $i));
                }
            } else {
                $this->view->editLanesForm = $editLanesForm;
            }
        }
    }
    
    public function editCennikAction()
    {
        $db = Zend_Db_Table_Abstract::getDefaultAdapter();
        $sqlstr = "SELECT * FROM cennik";
        $editCennikForm = new Application_Form_Admin_EditCennik();
        
        $this->view->cennik = $db->query($sqlstr)->fetchAll();
        $this->view->editCennikForm = $editCennikForm;
    }
    
    public function updateCennikAction()
    {
        $editCennikForm = new Application_Form_Admin_EditCennik();
        if($this->getRequest()->isPost()) {
            $db = Zend_Db_Table_Abstract::getDefaultAdapter();
            $sqlstr = "SELECT idCennik, Cena FROM cennik";
            $cennikResults = $db->query($sqlstr)->fetchAll();
               
            if($editCennikForm->isValid($_POST)) {
                $values = $editCennikForm->getValues();
                
                foreach($cennikResults as $entry) {
                    if($entry['Cena'] != $values[$entry['idCennik']]) {
                        $sqlstr = "UPDATE cennik SET cena = ? WHERE idCennik = ?";
                        $db->query($sqlstr, 
                            array($values[$entry['idCennik']], $entry['idCennik']));
                    }
                }
            } else {
                $this->view->editCennikForm = $editCennikForm;
                
                foreach($cennikResults as $entry) {
                    $editCennikForm->getElement($entry['idCennik'])
                            ->setValue($entry['Cena']);
                }
            }
        }
    }
    
    public function indexGodzinyOtwarciaAction()
    {
        $db = Zend_Db_Table_Abstract::getDefaultAdapter();
        $sqlstr = "SELECT * FROM godziny_otwarcia";
        $this->view->godzinyOtwarcia = $db->query($sqlstr)->fetchAll();
    }
    
    public function editGodzinyOtwarciaAction()
    {
        $editGodzinyOtwarciaForm = new Application_Form_Admin_EditGodzinyOtwarcia();
        $day = $this->getRequest()->getParam('day');
        $this->view->editGodzinyOtwarciaForm = $editGodzinyOtwarciaForm;
        $this->view->day = $day;
    }
    
    public function updateGodzinyOtwarciaAction()
    {
        $day = $this->getRequest()->getParam('day');
            
        $db = Zend_Db_Table::getDefaultAdapter();
        $sqlstr = "SELECT * FROM godziny_otwarcia WHERE idGodzinyOtwarcia = ?";
        $dzienTygodnia = $db->query($sqlstr, $day)->fetch();
        
        if(!is_null($dzienTygodnia['GodzinaOtwarcia'])) {
            $editGodzinyOtwarciaForm = new Application_Form_Admin_EditGodzinyOtwarcia();
            if($this->getRequest()->isPost() && 
                $editGodzinyOtwarciaForm->isValid($_POST)) {
                $values = $editGodzinyOtwarciaForm->getValues();
                    
                $sqlstr  = "UPDATE godziny_otwarcia ";
                $sqlstr .= "SET GodzinaOtwarcia = ?, GodzinaZamkniecia = ? ";
                $sqlstr .= "WHERE idGodzinyOtwarcia = ?";

                $db->query($sqlstr, array(
                        $values['GodzinaOtwarcia'],
                        $values['GodzinaZamkniecia'],
                        $day
                    ));
            } else {
                $this->view->error = "Nie POST albo nieprawidłowe dane";
            }
        }
    }
    
    public function indexAktualnosciAction()
    {
        $aktualnosciModel = new Application_Model_Aktualnosci();
        $this->view->aktualnosci = $aktualnosciModel->wszystkieAktualnosci();
    }
    
    public function newAktualnoscAction()
    {
        $newAktualnoscForm = new Application_Form_Admin_NewAktualnosc();
        $this->view->newAktualnoscForm = $newAktualnoscForm;
        
        if($this->getRequest()->isPost()) {
            if($newAktualnoscForm->isValid($_POST)) {
                $values = $newAktualnoscForm->getValues();
                $this->view->newAktualnoscForm = null;
                
                $aktualnosciModel = new Application_Model_Aktualnosci();
                $dataArray = explode(".", $values['Data']);
                $dataUSformat = $dataArray[2] . "-" . $dataArray[1] . "-" . $dataArray[0];
                $czyAktualne = $values['czyAktualne'] ? 1 : 0;
                $aktualnosciModel->dodajAktualnosc($values['naglowek'], $values['tresc'], $dataUSformat, $czyAktualne);
            }
        }
    }
    
    public function editAktualnoscAction()
    {
        $aktualnoscModel = new Application_Model_Aktualnosci();
        $id=$this->getRequest()->getParam('id');
        
        $this->view->id = $id;
        $aktualnosc = $aktualnoscModel->pobierzAktualnoscPoId($id);
       
        $this->view->aktualnosc = $aktualnosc;
        $dataArray = explode("-", $aktualnosc['Data']);
        $dataPLformat = empty($aktualnosc['Data']) ? "" : $dataArray[2].".".$dataArray[1].".".$dataArray[0];
        $czyAktualne = $aktualnosc['czyAktualne'] == 0 ? FALSE : TRUE;
        
        $newAktualnoscForm = new Application_Form_Admin_NewAktualnosc();
        $newAktualnoscForm->setAction('update-aktualnosc');
        $newAktualnoscForm->getElement("id")->setValue($id);
        $newAktualnoscForm->getElement("naglowek")->setValue($aktualnosc['naglowek']);
        $newAktualnoscForm->getElement("Data")->setValue($dataPLformat);
        $newAktualnoscForm->getElement("czyAktualne")->setValue($czyAktualne);
        $newAktualnoscForm->getElement("tresc")->setValue($aktualnosc['tresc']);
        
        $this->view->editAktualnoscForm = $newAktualnoscForm;
    }
    
    public function updateAktualnoscAction()
    {
        $aktualnoscModel = new Application_Model_Aktualnosci();
        
        $id = $this->getRequest()->getParam('id');
        $newAktualnoscForm = new Application_Form_Admin_NewAktualnosc();
       
        if($this->getRequest()->isPost()) {
            
            if($newAktualnoscForm->isValid($_POST)) {
                $values = $newAktualnoscForm->getValues();
                
                $dataArray = explode(".", $values['Data']);
                $dataUSformat = $dataArray[2] . "-" . $dataArray[1] . "-" . $dataArray[0];
                $czyAktualne = $values['czyAktualne'] ? 1 : 0;
                
                $aktualnosc = $aktualnoscModel->aktualizujAktualnosc($id, $values['naglowek'], $values['tresc'], $dataUSformat, $czyAktualne);
            } else {
                $aktualnosc = $aktualnoscModel->pobierzAktualnoscPoId($id);
                $dataArray = explode("-", $aktualnosc['Data']);
                $dataEUformat = empty($aktualnosc['Data']) ? "" : $dataArray[2] . "." . $dataArray[1] . "." . $dataArray[0];
                $czyAktualne = $aktualnosc['czyAktualne'] == 0 ? FALSE : TRUE;
                
                $newAktualnoscForm->getElement("naglowek")->setValue($aktualnosc['naglowek']);
                $newAktualnoscForm->getElement("Data")->setValue($dataEUformat);
                $newAktualnoscForm->getElement("tresc")->setValue($aktualnosc['tresc']);
                $newAktualnoscForm->getElement('czyAktualne')->setValue($czyAktualne);
                
                $this->view->editAktualnoscForm = $newAktualnoscForm;
            }
        }
        
    }

	public function statsAction(){
		$this->view;
	}
}









