<?php
/**
 * @category Zebra
 * @package  Zebra_Validate
 */

/**
 * @see Zend_Validate_Abstract
 */
require_once 'Zend/Validate/PostCode.php';

/**
 * @uses     Zend_Validate_PostCode
 * @category Zebra
 * @package  Zebra_Validate
 */
class Zebra_Validate_Cep extends Zend_Validate_PostCode
{
    /**
     * @return void
     */
    public function __construct()
    {
        $this->_locale = 'pt_BR';
    }


    public function setLocale($locale)
    {
        require_once 'Zebra/Validate/Exception.php';
        throw new Zebra_Validate_Exception('Chamada deste método não permitida');
    }

    public function setFormat($format)
    {
        require_once 'Zebra/Validate/Exception.php';
        throw new Zebra_Validate_Exception('Chamada deste método não permitida');
    }
}
