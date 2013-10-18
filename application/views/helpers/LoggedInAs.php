<?php
class Zend_View_Helper_LoggedInAs extends Zend_View_Helper_Abstract

{

    public function loggedInAs ()

    {

        $auth = Zend_Auth::getInstance();
        if ($auth->hasIdentity()) {

         $role =$auth->getStorage()->read()->Role;
         $userID = $auth->getIdentity()->idUzytkownik;
         //echo $userID;
         
               if ($role == 'klient') {
                        $DbTableKlient = new Application_Model_Klient();
                        $klient = $DbTableKlient->klientIDUzytkownik($userID)->fetchAll();
                        $idKlient= $klient[0]['idKlient'];
                        return $idKlient;
                  }

        }

    }

}

