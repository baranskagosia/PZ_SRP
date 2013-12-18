<?php

class Application_Form_Admin_NewAktualnosc extends Zend_Form
{

    public function init()
    {
        $current_action = Zend_Controller_Front::getInstance()->getRequest()->getActionName();
        $target_action = "new-aktualnosc";
        $submit_label = "Dodaj Aktualność!";
        if($current_action == "edit-aktualnosc" || $current_action == "update-aktualnosc") {
            $url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

            $tmp = explode('/', $url);
            $id=$tmp[7];
            $target_action = "../update-aktualnosc/$id";
            $submit_label = "Edytuj aktualność";
        }
        
        $this->setAction($target_action)->setMethod('post');
        
        $validatorNotEmpty = new Zend_Validate_NotEmpty();
        $validatorNotEmpty->setMessage('To pole jest wymagane.');
        
        $naglowek = new Zend_Form_Element_Text("naglowek");

        $naglowek->setRequired(true)->setLabel('Nagłówek: ')
                ->addValidator($validatorNotEmpty);
        $naglowek->addDecorators(array(
            array('Errors'),
        ));
        $this->addElement($naglowek);
        
        $tresc = new Zend_Form_Element_Textarea('tresc');
        $tresc->setRequired(true)->setLabel('Treść: ')
                ->addValidator($validatorNotEmpty);
        $tresc->addDecorators(array(
            array('Errors'),
        ));
        $this->addElement($tresc);
        
 
        $this->addElement('submit', 'register', array('label' => $submit_label));
    }


}

