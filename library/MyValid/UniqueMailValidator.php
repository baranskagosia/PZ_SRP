<?php 
class MyValid_UniqueMailValidator extends Zend_Validate_Abstract
    {
    const MSG_NOT_UNIQUE = "not_unique"; 
    
        protected $_messageTemplates = array(
            self::MSG_NOT_UNIQUE => "Użytkownik '%value%' już istnieje w bazie danych.",
        );
        
        public function setMessage($messageString, $messageKey = null) {
            parent::setMessage($messageString, $messageKey);
            if(is_null($messageKey) || $messageKey == self::MSG_NOT_UNIQUE) {
                $_messageTemplates[self::MSG_NOT_UNIQUE] = $messageString;
            }
        }
     
        public function isValid($value)
        {
            $this->_setValue($value);
            
            $db = Zend_Db_Table_Abstract::getDefaultAdapter();
            $sqlstr = "SELECT * FROM uzytkownik WHERE Mail = '?'";
            $result = $db->query($sqlstr, $value)->fetch();
     
            if (!empty($value)) {
                $this->_error(self::MSG_NOT_UNIQUE);
                return false;
            }
     
            return true;
        }
}
