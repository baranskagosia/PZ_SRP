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

    public function newAction()
    {
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
    	$helper= $this->view->getHelper('LoggedInAs');
        $idKlient=$helper->loggedInAs();
	
		if(Zend_Auth::getInstance()->hasIdentity()){
           // $this->_redirect('index/index');
        
        $request =$this ->getRequest();
        $form =new Application_Form_Edit();
        
		 if($request->isPost()){
            if($form->isValid($this->_request->getPost())){
                    	
				$imie = $form->getValue('Imie');
				$nazwisko = $form->getValue('Nazwisko');
				$telefon = $form->getValue('Telefon');
				
				$db = Zend_Db::factory('Pdo_Mysql', array(
			    'host'     => 'localhost',
			    'username' => 'B02',
			    'password' => 'B02',
			    'dbname'   => 'pz_srp'
			));
			
				$sql = $db->select('idUzytkownik')->from(array('k' => 'klient'))->join(array('u'=>'uzytkownik'), 'k.idUzytkownik = u.idUzytkownik')->where('idKlient LIKE ?', $idKlient);;
				$stmt = $sql->query();
				$result = $stmt->fetchAll();
				
				$data = array(
					'Imie' => $imie,
					'Nazwisko'=> $nazwisko,
					'Telefon'=> $telefon);
				
				$sql2 = $db->update('klient', $data, 'idUzytkownik LIKE '.$result[0]['idUzytkownik']);
					
					
			
			}}        
         }
    $this->view->form =$form;
	}
	
	public function daneHasloAction()
    {
    	$form =new Application_Form_Haslo();
         
		$helper= $this->view->getHelper('LoggedInAs');
        $idKlient=$helper->loggedInAs();
		$request =$this ->getRequest();
        
		if($this->_request->isPost()){
			
			//var_dump($this->getRequest()->getPost());
			if($form->isValid($this->getRequest()->getPost())){
        
		
			       	//$Haslo_old=$form->getValue('Haslo_old');
			        $Haslo_new1=$form->getValue('Haslo_new1');
			        $Haslo_new2=$form->getValue('Haslo_new2');
			        
			        //$Pass_old=md5($Haslo_old);
			        $Pass_new1=md5($Haslo_new1);
					$Pass_new2=md5($Haslo_new2);
			  	
							
					//echo 'po '.$Pass_old.' '.$Haslo_old.'<br>';
					//echo 'pn '.$Pass_new1.' '.$Haslo_new1.'<br>';
					//echo 'pnn '.$Pass_new2.' '.$Haslo_new2.'<br>';
					
					$db = Zend_Db::factory('Pdo_Mysql', array(
					    'host'     => 'localhost',
					    'username' => 'B02',
					    'password' => 'B02',
					    'dbname'   => 'pz_srp'
					));
						
					$sql = $db->select('idUzytkownik')->from(array('k' => 'klient'))->join(array('u'=>'uzytkownik'), 'k.idUzytkownik = u.idUzytkownik')->where('idKlient LIKE ?', $idKlient);;
		    		$stmt = $sql->query();
					$result = $stmt->fetchAll();
					
					//echo $result[0]['idUzytkownik'];
		
				    $data = array(
						'Haslo' => $Pass_new2);
						
					if($Pass_new1 == $Pass_new2){
						$sql2 = $db->update('uzytkownik', $data, 'idUzytkownik LIKE '.$result[0]['idUzytkownik']);
					}
					else{
						$this->view->form =$form;
						echo 'Hasła się nie zgadzają!';
					}
 					//$this->view->form =$form;
					$this->view->idKlient = $idKlient;
					
					echo 'Hasło zostało zmienione';
					}
  			}	
			else{
 				//var_dump($this->getRequest()->getPost());
				$this->view->form =$form;
				$this->view->idKlient = $idKlient;
			}
		}

    public function daneUsunAction()
    {}
	
	public function daneByeAction()
    {	
	    $helper= $this->view->getHelper('LoggedInAs');
        $idKlient=$helper->loggedInAs();
    
        $this->view->idKlient=$idKlient;
	    
	$db = Zend_Db::factory('Pdo_Mysql', array(
    'host'     => 'localhost',
    'username' => 'B02',
    'password' => 'B02',
    'dbname'   => 'pz_srp'
));

	$sql = $db->select('idUzytkownik')->from(array('k' => 'klient'))->join(array('u'=>'uzytkownik'), 'k.idUzytkownik = u.idUzytkownik')->where('idKlient LIKE ?', $idKlient);;
	$stmt = $sql->query();
	$result = $stmt->fetchAll();
	
	$data = array(
		'Aktywny' => 0);
	
	$sql2 = $db->update('uzytkownik', $data, 'idUzytkownik LIKE '.$result[0]['idUzytkownik']);
		
		
	Zend_Auth::getInstance()->clearIdentity();
    $this->_redirect('index/index');   
		
}
	    
   // }
	
	public function daneHaslo(){
		
	}

    public function rezerwacjeAction()
    {
        // action body
    }

    public function historiaAction()
    {
        // action body
    }

    public function odwolajRezerwacjeAction()
    {
        $IDRezerwacja = $this->getRequest()->getParam('IDRezerwacja');
        $this->view->IDRezerwacja=$IDRezerwacja;
        $table=new Application_Model_Rezerwacja;
       
             $where = $table->getAdapter()->quoteInto('idrezerwacja= ?', $IDRezerwacja);
             $table->delete($where);
       
       $this->_redirect('klient/rezerwacje');
        
    }


}











