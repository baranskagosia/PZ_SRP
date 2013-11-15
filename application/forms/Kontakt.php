<?php

class Application_Form_Kontakt extends Form_Base
{

public function init()
{

// The user's name
$name = new Zend_Form_Element_Text('name');
$name->setAttrib('style','width:240px;')
->setAttrib('placeholder', 'Your Name');

// The user's email address
$email = new Zend_Form_Element_Text('email');
$email->setAttrib('style','width:240px;')
->setAttrib('placeholder', 'Email')
->addValidator('EmailAddress')
->setRequired('true');
// The user's message
$message = new Zend_Form_Element_Textarea('message');
$message->setAttrib('placeholder', 'Message')
->setRequired('true');

// Add the elements to the form.

$this->addElements(array($name, $email, $message));

}

}