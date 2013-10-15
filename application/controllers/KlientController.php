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
        $IDKlient=$helper->loggedInAs();
        $this->view->kto=$IDKlient;
// action body
    }

    public function daneAction()
    {
        $db=Zend_Db_Table_Abstract::getDefaultAdapter();
        $helper= $this->view->getHelper('LoggedInAs');
        $IDKlient=$helper->loggedInAs();

        $DbTable = new Application_Model_Users();
        $Dane = $DbTable->dane($IDKlient);
        $this->view->dane = $Dane;

    }

    public function daneEditAction()
    {
        // action body
    }


}





