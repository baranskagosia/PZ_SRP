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
        $IDKlient= $idKlient=$helper->loggedInAs();
        $db=Zend_Db_Table_Abstract::getDefaultAdapter();
              if(isset($IDKlient)){
             $idUSER="SELECT idUzytkownik FROM klient WHERE idKlient=$IDKlient";
             $ID=$db->query($idUSER)->fetchAll();
    
             $IDUzytkownik=$ID[0]['idUzytkownik'];
             
        }
       else{
           $IDUzytkownik=null;  
       }
       $month=date('m');
       $day=date('d');
      
       $SQLurodziny="SELECT DataUrodzenia
                    FROM klient 
                    WHERE  idKlient=$IDKlient 
                        AND Month(DataUrodzenia)= ". $month." 
                        AND Day(DataUrodzenia)=".$day. "";
        $urodziny=$db->query($SQLurodziny)->fetchAll();
     $this->view->urodziny=$urodziny;
     $this->view->IDUzytkownik=$IDUzytkownik;
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
        
		//
        $db = Zend_Db::factory('Pdo_Mysql', array(
        'host'     => 'serwer1326625.home.pl',
        'username' => '13829293_0000001',
        'password' => 'x0Sq9uHJ,9.l',
        'dbname'   => '13829293_0000001'
    ));
			
		$sql = $db->select('idUzytkownik')->from(array('k' => 'klient'))->join(array('u'=>'uzytkownik'), 'k.idUzytkownik = u.idUzytkownik')->where('idKlient LIKE ?', $idKlient);;
		$stmt = $sql->query();
		$result = $stmt->fetchAll();
		
		$i = $result[0]['Imie'];
		$n = $result[0]['Nazwisko'];
		$t = $result[0]['Telefon'];
		$dane = array('Imie'=>$i, 'Nazwisko'=>$n,'Telefon'=>$t);
			
		//var_dump($i);
        $form =new Application_Form_Edit();
        $form->populate($dane);
		
		 if($request->isPost()){
            if($form->isValid($this->_request->getPost())){
                
				$imie = $form->getValue('Imie');
				$nazwisko = $form->getValue('Nazwisko');
				$telefon = $form->getValue('Telefon');
				
                        $db = Zend_Db::factory('Pdo_Mysql', array(
                                'host'     => 'serwer1326625.home.pl',
                                'username' => '13829293_0000001',
                                'password' => 'x0Sq9uHJ,9.l',
                                'dbname'   => '13829293_0000001'
                            ));
			
				$sql = $db->select('idUzytkownik')->from(array('k' => 'klient'))->join(array('u'=>'uzytkownik'), 'k.idUzytkownik = u.idUzytkownik')->where('idKlient LIKE ?', $idKlient);
				$stmt = $sql->query();
				$result = $stmt->fetchAll();
				
				$data = array(
					'Imie' => $imie,
					'Nazwisko'=> $nazwisko,
					'Telefon'=> $telefon);
				
				$sql2 = $db->update('klient', $data, 'idUzytkownik LIKE '.$result[0]['idUzytkownik']);
				echo '<font color="green">Edycja danych się powiodła</font>';
		
			}}        
         }
    $this->view->form =$form;
					
	}
	
	public function daneHasloAction()
    {
    	$helper= $this->view->getHelper('LoggedInAs');
        $idKlient=$helper->loggedInAs();
	
		if(Zend_Auth::getInstance()->hasIdentity()){
           // $this->_redirect('index/index');
        
        $request =$this ->getRequest();
        
        $form =new Application_Form_Haslo();
         
                if($this->_request->isPost()){
		        	if($form->isValid($this->getRequest()->getPost())){       
                        
						//$Haslo_old=$form->getValue('Haslo_stare');
                        $data = $this->getRequest()->getPost();
						//Zend_Debug::dump($data);
						
						$Haslo_old =$data['Haslo_stare'];
                        $Haslo_new1=$data['Haslo_new1'];
                        $Haslo_new2=$data['Haslo_new2'];
                        
						$Pass_old=md5($Haslo_old);
                        $Pass_new1=md5($Haslo_new1);
                        $Pass_new2=md5($Haslo_new2);
                        
						//var_dump($this->getRequest()->getPost());
						
                            $db = Zend_Db::factory('Pdo_Mysql', array(
                            'host'     => 'serwer1326625.home.pl',
                            'username' => '13829293_0000001',
                            'password' => 'x0Sq9uHJ,9.l',
                            'dbname'   => '13829293_0000001'
                        ));
                                                
                        $sql = $db->select('idUzytkownik')->from(array('k' => 'klient'))->join(array('u'=>'uzytkownik'), 'k.idUzytkownik = u.idUzytkownik')->where('idKlient LIKE ?', $idKlient);;
                 		$stmt = $sql->query();
                        $result = $stmt->fetchAll();
						
						$Pass_ok = $result[0]['Haslo'];
						
						$data2 = array('Haslo' => $Pass_new2);
                             
						if($Pass_old == $Pass_ok){
							$sql2 = $db->update('uzytkownik', $data2, 'idUzytkownik LIKE '.$result[0]['idUzytkownik']);
                            $this->view->idKlient = $idKlient;
                                        	
							echo '<font color="red">Hasło zostało zmienione</font>';
                            //echo "<p><a href='".$this->url(array( 'action'=>'dane', 'id'=>$idKlient))."' class='button'>Powrót</a> </p>";
                            }
						else{
							echo '<font color="red">Stare hasło jest nieprawidłowe!</font>';
						}
						}
				}
		}
        $this->view->form =$form;
        $this->view->idKlient = $idKlient;
		}

    public function daneUsunAction()
    {}
	
	public function daneByeAction()
    {	
	    $helper= $this->view->getHelper('LoggedInAs');
        $idKlient=$helper->loggedInAs();
    
        $this->view->idKlient=$idKlient;
	    
                    $db = Zend_Db::factory('Pdo_Mysql', array(
                            'host'     => 'serwer1326625.home.pl',
                            'username' => '13829293_0000001',
                            'password' => 'x0Sq9uHJ,9.l',
                            'dbname'   => '13829293_0000001'
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
         $db=Zend_Db_Table_Abstract::getDefaultAdapter();
        $helper= $this->view->getHelper('LoggedInAs');
        $IDKlient=$helper->loggedInAs();
        $idUSER="SELECT idUzytkownik FROM klient WHERE idKlient=$IDKlient";
        $ID=$db->query($idUSER)->fetchAll();
        $IDUzytkownik=$ID[0]['idUzytkownik'];
        
     
        $rezerwacjaModel = new Application_Model_Rezerwacja();
        
        $this->view->rezerwacje = $rezerwacjaModel->Zaplanowane($IDUzytkownik);
    }

    public function historiaAction()
    {
        $db=Zend_Db_Table_Abstract::getDefaultAdapter();
        $helper= $this->view->getHelper('LoggedInAs');
        $IDKlient=$helper->loggedInAs();
        $idUSER="SELECT idUzytkownik FROM klient WHERE idKlient=$IDKlient";
        $ID=$db->query($idUSER)->fetchAll();
        $IDUzytkownik=$ID[0]['idUzytkownik'];
        
     
        $rezerwacjaModel = new Application_Model_Rezerwacja();
        
        $this->view->rezerwacje = $rezerwacjaModel->Historia($IDUzytkownik);
    }

    public function odwolajRezerwacjeAction()
    {

        $IDRezerwacja = $this->getRequest()->getParam('IDRezerwacja');
        $this->view->IDRezerwacja=$IDRezerwacja;
        $table=new Application_Model_Rezerwacja;
        $sql="SELECT * FROM rezerwacja where idRezerwacja LIKE $IDRezerwacja";
                    $db=Zend_Db_Table_Abstract::getDefaultAdapter();
                    $dane=$db->query($sql)->fetchAll();;
        $dane[0]['CzyOdwolana']=1;
                    print_r($dane);
        
       
           // $where = $table->getAdapter()->quoteInto('idrezerwacja= ?', $IDRezerwacja);
           $table->update($dane[0], "idRezerwacja=".$IDRezerwacja);
       
      $this->_redirect('klient/rezerwacje');
        
    }


}











