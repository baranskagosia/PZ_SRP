<?php

class Application_Form_Admin_NewAktualnosc extends Zend_Form
{

    public function init()
    {
        $current_action = Zend_Controller_Front::getInstance()->getRequest()->getActionName();
      
        $submit_label = "Dodaj Aktualność!";
        if($current_action == "edit-aktualnosc" || $current_action == "update-aktualnosc") {

            $submit_label = "Edytuj aktualność";
        }
        
        $this->setMethod('post');
        
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
        
        $id = new Zend_Form_Element_Hidden("id");
         $this->addElement($id);
                 
        $this->addElement('submit', 'register', array('label' => $submit_label));
    }


}

