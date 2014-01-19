<?php 
class MyValid_UniqueMailValidator extends Zend_Validate_Abstract
    {
    const MSG_NOT_UNIQUE = "not_unique"; 
    
        protected $_db = null;
        protected $_tableName = "";
        protected $_messageTemplates = array(
            self::MSG_NOT_UNIQUE => "Użytkownik '%value%' już istnieje w bazie danych.",
        );
        
        public function __construct($tableName)
        {
            $this->_tableName = $tableName;
            $this->_db = Zend_Db_Table_Abstract::getDefaultAdapter();
        }
        
        public function setMessage($messageString, $messageKey = null) {
            parent::setMessage($messageString, $messageKey);
            if(is_null($messageKey) || $messageKey == self::MSG_NOT_UNIQUE) {
                $_messageTemplates[self::MSG_NOT_UNIQUE] = $messageString;
            }
        }
     
        public function isValid($value, $context = null)
        {
            $this->_setValue($value);            
            
            $sqlstr = "SELECT * FROM uzytkownik WHERE Mail = '?'";
            $result = $this->_db->query($sqlstr, $value)->fetchAll();
     
            if (count($result) > 0) {
                $this->_error(self::MSG_NOT_UNIQUE);
                return FALSE;
            } else {
                return TRUE;
            }
        }
}
