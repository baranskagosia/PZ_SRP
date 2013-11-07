<?php

class KlientController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
         $helper= $this->view->getHelper('LoggedInAs');
         $idKlient=$helper->loggedInAs();
    
        $this->view->idKlient=$idKlient;
// action body
    }

    public function daneAction()
    {
        $helper= $this->view->getHelper('LoggedInAs');
        $idKlient=$helper->loggedInAs();
    
        $this->view->idKlient=$idKlient;

        $DbTable = new Application_Model_Klient();
        $dane = $DbTable->klientDane($idKlient);
        $this->view->dane = $dane;

    }
    
    public function newAction() {
        $this->view->registrationForm = new Application_Form_NewKlient();
    }
    
        public function createAction()
    {
        $usersModel = new Application_Model_Users();
        $klientModel = new Application_Model_Klient();
        $registrationForm = new Application_Form_NewKlient();
        
        if($this->getRequest()->isPost()) {
            if($registrationForm->isValid($_POST)) {
                $values = $registrationForm->getValues();
                
                $badRegistration = false;
                $db = Zend_Db_Table::getDefaultAdapter();
                try {
                    $db->beginTransaction();
                    
                    $usersModel->addNewUser($values['Mail'], md5($values['Haslo']), 'klient');
                    $idUzytkownik = $usersModel->getAdapter()->lastInsertId();
                    $klientModel->add($values['Imie'], $values['Nazwisko'], 1);
                    
                    $db->commit();
                } catch(Zend_Db_Statement_Exception $e) {
                    $db->rollback();
                    throw $e;
                    //TODO: sprawdzenie warunków, przy których może wystąpić
                    // "wyścig"
                }
            }
            else {
                $this->view->registrationForm = $registrationForm;
            }
        }
    }

    public function daneEditAction()
    {
        // action body
    }


}





