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

    public function daneEditAction()
    {
        // action body
    }


}





