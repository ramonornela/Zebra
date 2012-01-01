<?php
/**
 * @category Zebra
 * @package  Zebra_Validate
 */

/**
 * @see Zend_Validate_Abstract
 */
require_once 'Zend/Validate/Abstract.php';

/**
 * @uses     Zend_Validate_Abstract
 * @category Zebra
 * @package  Zebra_Validate
 */
class Zebra_Validate_Cpf extends Zend_Validate_Abstract
{
    /**#@+
     * @const separator mode
     */
    const FORMAT_SEPARATOR = 1;
    const FORMAT_CLEAN     = 2;
    const FORMAT_AUTO      = 3;
    /**#@-*/

    /**#@+
     * @const messages templates
     */
    const INVALID        = 'cpfInvalid';
    const INVALID_FORMAT = 'cpfInvalidFormat';
    const NOT_CPF        = 'notCpf';
    const SERVICE        = 'cpfService';
    /**#@-*/

    /**
     * @var integer
     */
    protected $_separatorMode = self::FORMAT_AUTO;

    /**
     * @var array
     */
    protected $_constants = array(
        'separator' => self::FORMAT_SEPARATOR,
        'clean'     => self::FORMAT_CLEAN,
        'auto'      => self::FORMAT_AUTO
    );

    /**
     * @var array
     */
    protected $_messageTemplates = array(
        self::INVALID        => 'Tipo de dado inválido. É esperado uma string',
        self::INVALID_FORMAT => 'Formatação é inválida',
        self::NOT_CPF        => "'%value%' não é um CPF válido",
        self::SERVICE        => "'%value%' seems to be an invalid creditcard number",
    );

    /**
     * @var callback
     */
    protected $_service = null;

    /**
     * @param  array|string|integer|Zend_Config $options
     * @return void
     */
    public function __construct($options = null)
    {
        if (null !== $options) {
            if ($options instanceof Zend_Config) {
                $options = $options->toArray();
            }

            if (!is_array($options)) {
                $options = array('separatorMode' => $options);
            } else if (array_key_exists('service', $options)) {
                $this->setService($options['service']);
            }

            if (array_key_exists('separatorMode', $options)) {
                $this->setSeparatorMode($options['separatorMode']);
            }
        }
    }

    /**
     * @param  array|string|integer $mode
     * @return Zebra_Validate_Cpf provides a fluent interface
     * @throws Zend_Validate_Exception
     */
    public function setSeparatorMode($mode)
    {
        if (!is_array($mode)) {
            $mode = array($mode);
        }

        $detected = 0;
        foreach ($mode as $value) {
            if (is_string($value)) {
                if (array_key_exists($value, $this->_constants)) {
                    $detected += $this->_constants[$value];
                }
            } else if (is_int($value)) {
                $detected += $value;
            }
        }

        if ($detected <= 0 || $detected > self::FORMAT_AUTO) {
            require_once 'Zebra/Validate/Exception.php';
            throw new Zebra_Validate_Exception('Modo desconhecido');
        }

        $this->_separatorMode = $detected;
        return $this;
    }

    /**
     * @param callback $service
     * @return Zebra_Validate_Cpf provides a fluent interface
     * @throws Zebra_Validate_Exception
     */
    public function setService($service)
    {
        if (!is_callable($service)) {
            require_once 'Zebra/Validate/Exception.php';
            throw new Zebra_Validate_Exception('Callback inválido');
        }

        $this->_service = $service;
        return $this;
    }

    /**
     * @return integer
     */
    public function getSeparatorMode()
    {
        return $this->_separatorMode;
    }

    /**
     * @return callback
     */
    public function getService()
    {
        return $this->_service;
    }

    /**
     * @see Zend_Validate_Interface::isValid()
     */
    public function isValid($value)
    {
        if (!is_string($value)) {
            $this->_error(self::INVALID);
            return false;
        }

        $this->_setValue($value);
        $mode = $this->getSeparatorMode();

        if (self::FORMAT_SEPARATOR === $mode) {
            if (!preg_match('/^\d{3}\.\d{3}\.\d{3}-\d{2}$/', $value)) {
                $this->_error(self::INVALID_FORMAT);
                return false;
            }
            $value = $this->_cleanFormat($value);
        } else if (self::FORMAT_AUTO === $mode) {
            if (!preg_match('/^\d{3}\.\d{3}\.\d{3}-\d{2}$/', $value) &&
                !preg_match('/^\d{11}$/', $value)) {
                $this->_error(self::INVALID_FORMAT);
                return false;
            }
            $value = $this->_cleanFormat($value);
        } else if (self::FORMAT_CLEAN === $mode) {
            if (!preg_match('/^\d{11}$/', $value)) {
                $this->_error(self::INVALID_FORMAT);
                return false;
            }
        }

        // checksum
        $check = $this->_checkSum($value, 10)
              && $this->_checkSum($value, 11);

        if (!$check) {
            $this->_error(self::NOT_CPF);
            return false;
        }

        if (null !== $this->_service) {
            require_once 'Zend/Validate/Callback.php';
            $callback = new Zend_Validate_Callback($this->_service);
            $callback->setOptions($this->_separatorMode);
            if (!$callback->isValid($value)) {
                $this->_error(self::SERVICE, $value);
                return false;
            }
        }

        return true;
    }

    /**
     * @param  string  $value
     * @param  integer $digit
     * @return boolean
     */
    protected function _checkSum($value, $digit)
    {
        // sum
        $sum = 0;
        for ($i = 0; $i < $digit - 1; $i++) {
            $sum += $value[$i] * ($digit - $i);
        }

        // remain
        $remain = 11 - ($sum % 11);
        if ($remain == 10 || $remain == 11) {
            $remain = 0;
        }

        // check
        return $remain == $value[$digit - 1];
    }

    /**
     * @param string $value
     * @return string
     */
    protected function _cleanFormat($value)
    {
        return str_replace(array('.', '-'), '', $value);
    }
}
