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
    
    public function indexRezerwacjeAction() {
        $url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        $tmp = explode('/', $url);
        
        $date = $tmp[sizeof($tmp)-1];
        $date_regex = "/^(0[1-9]|[12][0-9]|3[01])[\.](0[1-9]|1[012])[\.](19|20)\d\d$/";
        if(preg_match($date_regex, $date)) {
            $data_format=date("Y-m-d", strtotime($date));
            
            $db = Zend_Db_Table::getDefaultAdapter();
            $sqlstr  = "SELECT * ";
            $sqlstr .= "FROM rezerwacja JOIN klient";
            $sqlstr .= "    ON rezerwacja.uzytkownik_idUzytkownik = klient.idKlient ";
            $sqlstr .= "WHERE rezerwacja.CzyOdwolana = 0 ";
            $sqlstr .= "AND DATE(rezerwacja.DataCzas) = '$data_format'";
            $this->view->rezerwacje_list = $db->query($sqlstr, $data_format)->fetchAll();
            
        } else {
            $this->view->error = "Błędny format daty (".$date.")";
        }
    }
    
    public function deleteRezerwacjaAction()
    {

        $IDRezerwacja = $this->getRequest()->getParam('IDRezerwacja');
        $this->view->IDRezerwacja=$IDRezerwacja;
        $table=new Application_Model_Rezerwacja;
        $sql="SELECT * FROM rezerwacja where idRezerwacja LIKE $IDRezerwacja";
                    $db=Zend_Db_Table_Abstract::getDefaultAdapter();
                    $dane=$db->query($sql)->fetch();
        $dane['CzyOdwolana']=1;
        //print_r($dane);
        
        $table->update($dane, "idRezerwacja=".$IDRezerwacja);
       
        $this->_redirect('recepcja/index-rezerwacje');
        
    }
	
    public function indexRankingAction() {
        Zend_Layout::getMvcInstance()->assign('enable_jQuery', TRUE);
        Zend_Layout::getMvcInstance()->assign('enable_jQuery_tablesorter', TRUE);
        
        $db = Zend_Db_Table::getDefaultAdapter();
        $sqlstr  = "SELECT * ";
        $sqlstr .= "FROM klient";
        $this->view->klient_ranking = $db->query($sqlstr)->fetchAll();
    }
}

