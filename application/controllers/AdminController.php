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


}









