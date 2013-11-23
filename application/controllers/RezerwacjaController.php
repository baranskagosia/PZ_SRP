<?php

class RezerwacjaController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $db=Zend_Db_Table_Abstract::getDefaultAdapter();
        $helper= $this->view->getHelper('LoggedInAs');
        $IDKlient=$helper->loggedInAs();
        $idUSER="SELECT idUzytkownik FROM klient WHERE idKlient=$IDKlient";
        $ID=$db->query($idUSER)->fetchAll();
    
        $IDUzytkownik=$ID[0]['idUzytkownik'];
        $this->view->IDUzytkownik=$IDUzytkownik;
       
        $url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

        $tmp = explode('/', $url);
        $data=$tmp[7];
        $time=$tmp[8];
        $tor=$tmp[9];
        
        $this->view->data=$data;
        $this->view->time=$time;
        $this->view->tor=$tor;
        
        $data_format=date("Y-m-d", strtotime($data));
       

        
        $form= new Application_Form_Rezerwacja;
        $this->view->form= $form;
    }

    public function rezerwacjaZapisAction()
    {
        $db=Zend_Db_Table_Abstract::getDefaultAdapter();
    $helper= $this->view->getHelper('LoggedInAs');
    $IDKlient=$helper->loggedInAs();
    $idUSER="SELECT idUzytkownik FROM klient WHERE idKlient=$IDKlient";
    $ID=$db->query($idUSER)->fetchAll();
    
   $IDUzytkownik=$ID[0]['idUzytkownik'];
    //print_r($IDUzytkownik);
      $request =$this ->getRequest();
     
      $DbTable= new Application_Model_Rezerwacja;
      $form=new Application_Form_Rezerwacja;
      //$form->populate($result->toArray());
        if($request->isPost()){
            if($form->isValid($request->getPost())){
               $data=$form->getValues();
                $sql_cena="SELECT idCennik FROM `cennik` WHERE OsobaTyp='".$data['Osoba']."' AND CzyWylacznosc=".$data['CzyNaWylacznosc']."";
                $cena=$db->query($sql_cena)->fetchAll();
              
                $data['cena_idcennik']=$cena[0]['idCennik'];
               //print_r($data);
                     $DataCzas=$data['DataCzas'];
                     $TorPreferowany=$data['TorPreferowany'];
                     $IloscOsob=$data['IloscOsob'];
                     $CzyNaWylacznosc=$data['CzyNaWylacznosc'];
                     $CzyOdwolana=$data['CzyOdwolana'];
                     $CzasTrwania=$data['CzasTrwania'];
             
                     $Cena=$data['cena_idcennik'];
                     
                    
              /*$DbTable->Dodawanie($DataCzas, $TorPreferowany, $IloscOsob, 
                                $CzyNaWylacznosc, $CzyOdwolana,$CzasTrwania,
                                 $IDUzytkownik,$Cena);*/
            $sql="CALL Rezerwacja_Indywidualna_Dodawanie('".$DataCzas."','".$TorPreferowany."',
            '".$IloscOsob."','".$CzyNaWylacznosc."','".$CzyOdwolana."','".$CzasTrwania."',
                '".$IDUzytkownik."','".$Cena."')";
            
            $db-> query($sql);
               
               $message="<div class='confirm-box'><p>Rezerwacja przebiegła poprawnie</p></div>";;
               }
               else{
                   $message="<div class='error-box'><p>Wystąpił błąd walidacji</p></div>";
               }
             
       }
       else{
            $message="<div class='info'><p>Nie udało się pobrać danych rezerwacji</p></div>";
       }
        $this->view->message =$message;
    }

    public function wyswietlAction() {
        $helper= $this->view->getHelper('LoggedInAs');
        $IDUzytkownik=$helper->loggedInAs();
        
        $rezerwacjaModel = new Application_Model_Rezerwacja();
        
        $this->view->rezerwacje = $rezerwacjaModel->Przyszle($IDUzytkownik);
    }

}



