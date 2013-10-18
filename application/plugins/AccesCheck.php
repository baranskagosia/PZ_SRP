<?php

class Application_Plugin_AccesCheck extends Zend_Controller_Plugin_Abstract{

    private $_acl =null;
    private $_auth =null;

    public function  __construct(Zend_Acl $acl ,$auth) {
        $this-> _acl = $acl;
        $this-> _auth = $auth;
    }

//preDispatch befor run controller najpierw sprawdzenie
    public function preDispatch(Zend_Controller_Request_Abstract $request){
        $resource=$request->getControllerName();
        $action=$request->getActionName();

        $identity= $this->_auth->getStorage()->read();
        if(isset($identity->Role)){
        $role =$identity->Role;
        $userID= $this->_auth->getStorage()->read();
        $id=$userID->idUzytkownik;
        }
        else{
            $role='gosc';
        }

        if(!$this->_acl->isAllowed($role, $resource, $action)){
            $request-> setControllerName('authentication')
                    ->setActionName('login');
        }  
      
    }
}

?>
