<?php
/**
 * @group Zebra_Validate
 */

/**
 * @see CpfProvider
 */
require_once dirname(__FILE__) . '/_files/Cpf/Provider.php';

class Zebra_Validate_CpfTest extends PHPUnit_Framework_TestCase
{
    protected $_validate = null;

    protected function setUp()
    {
        $this->_validate = new Zebra_Validate_Cpf();
    }

    /**
     * @dataProvider Cpf_Provider::construtor
     */
    public function testConstructor($params, $mode, $service = null)
    {
        $validate = new Zebra_Validate_Cpf($params);
        $this->assertEquals($mode, $validate->getSeparatorMode());
        $this->assertEquals($service, $validate->getService());
    }

    /**
     * @dataProvider              Cpf_Provider::invalidMode
     * @expectedException         Zebra_Validate_Exception
     * @expectedExceptionMessage  Modo desconhecido
     */
    public function testThrowExceptionIfInvalidMode($data)
    {
        $this->_validate->setSeparatorMode($data);
    }

    public function testInvalidType()
    {
        $this->assertFalse($this->_validate->isValid(null));
        $this->assertArrayHasKey('cpfInvalid', $this->_validate->getMessages());
    }

    /**
     * @dataProvider Cpf_Provider::invalidFormat
     */
    public function testInvalidFormat($data)
    {
        $this->_validate->setSeparatorMode($data['mode']);
        $this->assertFalse($this->_validate->isValid($data['cpf']));
        $this->assertArrayHasKey('cpfInvalidFormat', $this->_validate->getMessages());
    }

    /**
     * @dataProvider Cpf_Provider::invalidChecksum
     */
    public function testInvalidChecksum($invalidChecksum)
    {
        $this->assertFalse($this->_validate->isValid($invalidChecksum));
        $this->assertArrayHasKey('notCpf', $this->_validate->getMessages());
    }

    /**
     * @dataProvider Cpf_Provider::valids
     */
    public function testValid($data)
    {
        $this->_validate->setSeparatorMode($data['mode']);
        foreach ($data['cpf'] as $cpf) {
            $this->assertSame(
                $cpf['bool'],
                $this->_validate->isValid($cpf['value'])
            );
        }
    }

    /**
     * @expectedException         Zebra_Validate_Exception
     */
    public function testThrowExceptionInvalidCallbackService()
    {
        $this->_validate->setService(array('Cpf_Callback', 'invalidCallback'));
    }

    public function testServiceCallbackReturnInValid()
    {
        require_once  dirname(__FILE__) .'/_files/Cpf/Callback.php';
        $this->_validate->setService(array('Cpf_Callback', 'valid'));
        $this->assertFalse($this->_validate->isValid('111.111.111-11'));
        $this->assertArrayHasKey('cpfService', $this->_validate->getMessages());
    }

    public function testServiceCallbackReturnValid()
    {
        require_once  dirname(__FILE__) .'/_files/Cpf/Callback.php';
        $this->_validate->setService(array('Cpf_Callback', 'valid'));
        $this->assertTrue($this->_validate->isValid('22222222222'));
    }

    public function testServiceCallbackThrowException()
    {
        require_once  dirname(__FILE__) .'/_files/Cpf/Callback.php';
        $this->_validate->setService(array('Cpf_Callback', 'throwException'));
        $this->assertFalse($this->_validate->isValid('111.111.111-11'));
        $this->assertArrayHasKey('cpfService', $this->_validate->getMessages());
    }
}
