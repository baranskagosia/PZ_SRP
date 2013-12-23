<?php

class RecepcjaController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
    }

	public function reputacjaAction(){
		$this->view;
	}
	
	public function grafikAction(){
		$this->view;
		$DbTable = new Application_Model_Info();
        $iloscTorow = $DbTable->IloscTorow();
        $this->view->iloscTorow = $iloscTorow;
	}
	
	public function czyjestAction()
    {
    	$IDRezerwacja = $this->getRequest()->getParam('IDRezerwacja');
        $data = $this->getRequest()->getParam('Data');
		
		echo $IDRezerwacja;
       	$db = Zend_Db::factory('Pdo_Mysql', array(
			    'host'     => 'localhost',
			    'username' => 'B02',
			    'password' => 'B02',
			    'dbname'   => 'pz_srp'
			));
			
				$ar = array(
					'czyJest' => 1);
				
				$sql2 = $db->update('rezerwacja', $ar, 'idRezerwacja LIKE '.$IDRezerwacja);
				
		$this->_redirect('recepcja/grafik/'.$data);
    }
	
}

