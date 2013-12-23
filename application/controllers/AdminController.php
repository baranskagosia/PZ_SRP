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
        
        if($this->getRequest()->isPost()) {
            if($editLanesForm->isValid($_POST)) {
                $this->view->editLanesForm = null;
                
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
                $aktualnosciModel->dodajAktualnosc($values['naglowek'], $values['tresc']);
            }
        }
    }
    
    public function editAktualnoscAction()
    {
        $aktualnoscModel = new Application_Model_Aktualnosci();
        $url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

        $tmp = explode('/', $url);
        $id=$tmp[7];
        
        $this->view->id = $id;
        $aktualnosc = $aktualnoscModel->pobierzAktualnoscPoId($id);
        $this->view->aktualnosc = $aktualnosc;
        
        $newAktualnoscForm = new Application_Form_Admin_NewAktualnosc();
        $newAktualnoscForm->getElement("naglowek")->setValue($aktualnosc['naglowek']);
        $newAktualnoscForm->getElement("tresc")->setValue($aktualnosc['tresc']);
        
        $this->view->editAktualnoscForm = $newAktualnoscForm;
    }
    
    public function updateAktualnoscAction()
    {
        $aktualnoscModel = new Application_Model_Aktualnosci();
        $url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

        $tmp = explode('/', $url);
        $id=$tmp[7];
        $newAktualnoscForm = new Application_Form_Admin_NewAktualnosc();
        if($this->getRequest()->isPost()) {
            if($newAktualnoscForm->isValid($_POST)) {
                $values = $newAktualnoscForm->getValues();
                
                $aktualnosc = $aktualnoscModel->aktualizujAktualnosc($id, $values['naglowek'], $values['tresc']);
            }
        }
        
    }

	public function statsAction(){
		$this->view;
	}
}









