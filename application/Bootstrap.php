<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
   private $_acl =null;
   private $_auth =null;

   
    protected function _initAutoload(){

   $this-> _acl= new Application_Model_LibraryAcl();
   $this-> _auth = Zend_Auth::getInstance();
  
    $fc = Zend_Controller_Front::getInstance();
    $fc->registerPlugin(new Application_Plugin_AccesCheck($this->_acl,$this->_auth));

   
    }
     
   function _initViewHelpers(){

   $this->bootstrap('layout');
   $layout =$this->getResource('layout');
   $view =$layout-> getView();


   
   
$view->addHelperPath(APPLICATION_PATH . '/../library/ZendX/JQuery/View/Helper', 'ZendX_JQuery_View_Helper_');
$view->addHelperPath(APPLICATION_PATH .'/view/helpers/LoggedInAs', 'Zend_View_Helper_LoggedInAs');

  
     $view->jQuery()->enable()
             ->setVersion("1.9.1")
          //->setLocalPath('/../PZ_SRP/public/js/jquery/jquery-1.9.1.js')
          //   ->setUiVersion('1.8')
          //   ->addStylesheet('\..\public\jquery\jquery-ui-1.9.1.custom\jquery-ui-1.9.1.custom\css\sunnyjquery-ui-1.9.1.custom.min.css')//add the css
	    ;

   
  $navContainerConfig =new Zend_Config_Xml(APPLICATION_PATH . '/configs/navigation.xml','nav'); 
  $navContainer = new Zend_Navigation($navContainerConfig);

  
 if(isset($this->_auth->getStorage()->read()->Role)){
  $view->navigation($navContainer)->setAcl($this->_acl)->setRole($this->_auth->getStorage()->read()->Role);
 }
    }


   

}

