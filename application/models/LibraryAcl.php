<?php

class Application_Model_LibraryAcl extends Zend_Acl
{
   public function  __construct() {
       $this-> add(new Zend_Acl_Resource('index'));
       $this-> add(new Zend_Acl_Resource('login'));
       $this-> add(new Zend_Acl_Resource('logout'));
//     $this->add(new Zend_Acl_Resource('authentication'));
      
       $this-> add(new Zend_Acl_Resource('error'));
        $this-> add(new Zend_Acl_Resource('rezerwacja'));

       $this->add(new Zend_Acl_Resource('homeKlient'));
       $this->add(new Zend_Acl_Resource('klient'));
       $this->add(new Zend_Acl_Resource('klientDane'));

       $this->add(new Zend_Acl_Resource('umowKlient'));
       $this->add(new Zend_Acl_Resource('umowione'));
       $this->add(new Zend_Acl_Resource('historiaKlient'));

         $this->add(new Zend_Acl_Resource('homeRecepcja'));
         $this->add(new Zend_Acl_Resource('recepcja'));
         $this->add(new Zend_Acl_Resource('daneRecepcja'));
         $this->add(new Zend_Acl_Resource('recepcjaRezerwacje'));
         $this->add(new Zend_Acl_Resource('recepcjaRanking'));
         $this->add(new Zend_Acl_Resource('recepcjaGrafik'));
         $this->add(new Zend_Acl_Resource('recepcjaReputacja'));
         $this->add(new Zend_Acl_Resource('klienciWyswietl'));

         $this->add(new Zend_Acl_Resource('admin'));
         $this->add(new Zend_Acl_Resource('homeAdmin'));
         $this->add(new Zend_Acl_Resource('tabelki'));
         $this->add(new Zend_Acl_Resource('addRecepcja'));
		 $this->add(new Zend_Acl_Resource('stats'));
         $this->add(new Zend_Acl_Resource('newAktualnosc'));
         $this->add(new Zend_Acl_Resource('indexAktualnosci'));
         $this->add(new Zend_Acl_Resource('editCennik'));
         $this->add(new Zend_Acl_Resource('indexGodzinyOtwarcia'));
         $this->add(new Zend_Acl_Resource('editTor'));


         $this->add(new Zend_Acl_Resource('cennik'),'tabelki');
         
       //$this->add(new Zend_Acl_Resource(('show'),'lekarzs'));
       // $this->add(new Zend_Acl_Resource('showdane'),'lekarz');

       // $this-> add(new Zend_Acl_Resource('add'),'pacjent');
       //  $this->add(new Zend_Acl_Resource('edit'),'pacjent');

       //   $this-> add(new Zend_Acl_Resource('showdane'),'pacjent');

//Role w systemie

        $this->addRole(new Zend_Acl_Role('klient'));
        $this->addRole(new Zend_Acl_Role('gosc'));
        $this->addRole(new Zend_Acl_Role('recepcja'));
        $this->addRole(new Zend_Acl_Role('admin')); //admin ma tez mozliwosci jak pacjent

        //kto ma do czego dotęp kto, controller,akcja
//Dostęp

        $this->allow(null,array('index','error',));
       
        
       // $this->allow(null,'authentication' ,'login');
     
        $this->allow('klient', array('index','klient', 'rezerwacja', 'homeKlient','klientDane','umowione','umowKlient','historiaKlient','logout'));
       //  $this->allow('pacjent','wizyta','umow-pacjent');
//dostę RECEPCJA
        
        $this->allow('recepcja',array('index','recepcja','rezerwacja','homeRecepcja' ,'recepcjaRezerwacje', 'recepcjaRanking', 'recepcjaGrafik','recepcjaReputacja','klienciWyswietl','logout' ));
//dostęp admin
      
//  $this->deny ('admin','login');
       
        $this->allow ('admin', array('index', 'admin','homeAdmin','addRecepcja','stats', 'newAktualnosc', 'indexAktualnosci','editCennik' ,'indexGodzinyOtwarcia' ,'editTor' ,'logout'));

    }

}
