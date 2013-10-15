<?php

class AuthenticationController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }
 public function loginAction()
    {
 if(Zend_Auth::getInstance()->hasIdentity()){
           // $this->_redirect('index/index');
        }
        
        $request =$this ->getRequest();
         $form =new Application_Form_Login();
         if($request->isPost()){
            if($form->isValid($this->_request->getPost())){
                $authAdapter = $this ->getAuthAdapter();
                $Nazwa=$form->getValue('Nazwa');
                 $Pass=$form->getValue('Haslo');
                 $Haslo=md5($Pass);
                 
                 $authAdapter -> setIdentity($Nazwa)
                                ->setCredential($Haslo);

                 $auth =Zend_Auth::getInstance();
                 $result= $auth->authenticate($authAdapter);

                 if($result->isValid()){
                     $identity =$authAdapter ->getResultRowObject();
                                $authStorage =$auth ->getStorage();
                                 $authStorage->write($identity);
                                
                       }

                 }
   
             else{
                    $this->view->errorMessage = "Niepoprawna nazwa hała lub użytkownika";
                 }

           $this->_redirect($identity->Role);
         }
  $this->view->form =$form;
    
    }

    public function logoutAction()
    {
       Zend_Auth::getInstance()->clearIdentity();
       $this->_redirect('index/index');
    }

    private function getAuthAdapter(){
//$staticSalt = Zend_Registry::get('static_salt');
//$treatment = "SHA1(CONCAT(?, salt, '" . $staticSalt . "'))";

        $authAdapter =new Zend_Auth_Adapter_DbTable(Zend_Db_Table::getDefaultAdapter());
        $authAdapter->setTableName('uzytkownik')
                    ->setIdentityColumn('Mail')
                    //->setCredentialTreatment($treatment)
                    ->setCredentialColumn('Haslo');
                    
                 
        return $authAdapter;

    }
}



