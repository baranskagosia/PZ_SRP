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
        
        // Nagłówek aktualności
        $naglowek = new Zend_Form_Element_Text("naglowek");

        $naglowek->setRequired(true)->setLabel('Nagłówek: ')
                ->addValidator($validatorNotEmpty);
        $naglowek->addDecorators(array(
            array('Errors'),
        ));
        $this->addElement($naglowek);
        
        
        // Data aktualności
        $data = new Zend_Form_Element_Text("Data");
        $data->setValue(date('d.m.Y', time()));
        $dataRegexValidator = new Zend_Validate_Regex("/^(0[1-9]|[12][0-9]|3[01])[\.](0[1-9]|1[012])[\.](19|20)\d\d$/");
        $dataRegexValidator->setMessage("Nieprawidłowy format daty (poprawny format to dd.mm.YYYY)");

        $data->setRequired(true)->setLabel('Data dodania: ')
                ->addValidator($validatorNotEmpty)->addValidator($dataRegexValidator);
        $data->addDecorators(array(
            array('Errors'),
        ));
        $this->addElement($data);
        
        
        // Treść aktualności
        $tresc = new Zend_Form_Element_Textarea('tresc');
        $tresc->setRequired(true)->setLabel('Treść: ')
                ->addValidator($validatorNotEmpty);
        $tresc->addDecorators(array(
            array('Errors'),
        ));
        $this->addElement($tresc);
        
        $idHidden = new Zend_Form_Element_Hidden("id");
        $this->addElement($idHidden);
                 
        $this->addElement('submit', 'register', array('label' => $submit_label));
    }


}

