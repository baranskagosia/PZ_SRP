<?php

class Application_Model_LibraryAcl extends Zend_Acl
{
   public function  __construct() {
       $this-> add(new Zend_Acl_Resource('index'));
       $this-> add(new Zend_Acl_Resource('login'));
       $this-> add(new Zend_Acl_Resource('logout'));
//     $this->add(new Zend_Acl_Resource('authentication'));
      
       $this-> add(new Zend_Acl_Resource('error'));

       $this->add(new Zend_Acl_Resource('homeKlient'));
       $this->add(new Zend_Acl_Resource('klient'));
       $this->add(new Zend_Acl_Resource('klientDane'));

       $this->add(new Zend_Acl_Resource('umowKlient'));
       $this->add(new Zend_Acl_Resource('historiaKlient'));


         $this->add(new Zend_Acl_Resource('homeRecepcja'));
         $this->add(new Zend_Acl_Resource('recepcja'));
         $this->add(new Zend_Acl_Resource('daneRecepcja'));
         $this->add(new Zend_Acl_Resource('recepcjaRezerwacje'));
         $this->add(new Zend_Acl_Resource('recepcjaGrafik'));
         $this->add(new Zend_Acl_Resource('klienciWyswietl'));

         $this->add(new Zend_Acl_Resource('admin'));
         $this->add(new Zend_Acl_Resource('homeAdmin'));
         $this->add(new Zend_Acl_Resource('tabelki'));
         $this->add(new Zend_Acl_Resource('addRecepcja'));
         $this->add(new Zend_Acl_Resource('addKlient'));


         $this->add(new Zend_Acl_Resource('cennik'),'tabelki');
         
       //$this->add(new Zend_Acl_Resource(('show'),'lekarzs'));
       // $this->add(new Zend_Acl_Resource('showdane'),'lekarz');

       // $this-> add(new Zend_Acl_Resource('add'),'pacjent');
       //  $this->add(new Zend_Acl_Resource('edit'),'pacjent');

       //   $this-> add(new Zend_Acl_Resource('showdane'),'pacjent');

//Role w systemie

        $this->addRole(new Zend_Acl_Role('klient'));
        $this->addRole(new Zend_Acl_Role('recepcja'));
        $this->addRole(new Zend_Acl_Role('admin')); //admin ma tez mozliwosci jak pacjent

        //kto ma do czego dotęp kto, controller,akcja
//Dostęp

        $this->allow(null,array('index','error'));
       
        
       // $this->allow(null,'authentication' ,'login');
     
        $this->allow('klient', array('index','klient', 'homeKlient','klientDane','umowKlient','historiaKlient','logout'));
       //  $this->allow('pacjent','wizyta','umow-pacjent');
//dostę RECEPCJA
        
        $this->allow('recepcja',array('index','recepcja','homeRecepcja','daneRecepcja','recepcjaRezerwacje','recepcjaGrafik','klienciWyswietl','logout' ));
//dostęp admin
      
//  $this->deny ('admin','login');
        
        $this->allow ('admin', array('index', 'admin', 'tabelki','homeAdmin','addRecepcja','addKlient','logout'));
      
    }

}
