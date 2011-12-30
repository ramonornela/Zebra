<?php
/**
 * @group Zebra_Validate
 */
class Zebra_Validate_CpfTest extends PHPUnit_Framework_TestCase
{
    protected $_validate = null;

    protected function setUp()
    {
        $this->_validate = new Zebra_Validate_Cpf();
    }

    public function testConstructor()
    {
        $validate = new Zebra_Validate_Cpf(1);
        $this->assertEquals(1, $validate->getSeparatorMode());

        $validate = new Zebra_Validate_Cpf(array('separatorMode' => 2));
        $this->assertEquals(2, $validate->getSeparatorMode());

        $validate = new Zebra_Validate_Cpf(new Zend_Config(array('separatorMode' => 1)));
        $this->assertEquals(1, $validate->getSeparatorMode());
    }

    public function testSeparatorMode()
    {
        $this->_validate->setSeparatorMode(array('separator', 2));
        $this->assertEquals(3, $this->_validate->getSeparatorMode());

        $this->_validate->setSeparatorMode('clean');
        $this->assertEquals(2, $this->_validate->getSeparatorMode());

        $this->_validate->setSeparatorMode(array('separator', 'clean'));
        $this->assertEquals(3, $this->_validate->getSeparatorMode());

        $this->_validate->setSeparatorMode(1);
        $this->assertEquals(1, $this->_validate->getSeparatorMode());

        $this->_validate->setSeparatorMode(array(1, 2));
        $this->assertEquals(3, $this->_validate->getSeparatorMode());
    }

    /**
     * @dataProvider              providerInvalidMode
     * @expectedException         Zend_Validate_Exception
     * @expectedExceptionMessage  Unknow mode
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
     * @dataProvider providerInvalidFormat
     */
    public function testInvalidFormat($cpfSeparatorInvalid, $cpfCleanInvalid, $cpfAutoInvalid)
    {
        $this->_validate->setSeparatorMode('separator');
        $this->assertFalse($this->_validate->isValid($cpfSeparatorInvalid));
        $this->assertArrayHasKey('cpfInvalidFormat', $this->_validate->getMessages());

        $this->_validate->setSeparatorMode('clean');
        $this->assertFalse($this->_validate->isValid($cpfCleanInvalid));
        $this->assertArrayHasKey('cpfInvalidFormat', $this->_validate->getMessages());

        $this->_validate->setSeparatorMode('auto');
        $this->assertFalse($this->_validate->isValid($cpfAutoInvalid));
        $this->assertArrayHasKey('cpfInvalidFormat', $this->_validate->getMessages());
    }

    /**
     * @dataProvider providerInvalidChecksum
     */
    public function testInvalidChecksum($invalidChecksum)
    {
        $this->assertFalse($this->_validate->isValid($invalidChecksum));
        $this->assertArrayHasKey('notCpf', $this->_validate->getMessages());
    }

    public function testValid()
    {
        $this->assertTrue($this->_validate->isValid('111.111.111-11'));
        $this->assertTrue($this->_validate->isValid('11111111111'));

        $this->_validate->setSeparatorMode('clean');
        $this->assertTrue($this->_validate->isValid('11111111111'));
        $this->assertFalse($this->_validate->isValid('111.111.111-11'));

        $this->_validate->setSeparatorMode('separator');
        $this->assertTrue($this->_validate->isValid('222.222.222-22'));
        $this->assertFalse($this->_validate->isValid('22222222222'));
    }

    public function providerInvalidMode()
    {
        return array(
            array(null),
            array(4),
            array(array(-3, -2))
        );
    }

    public function providerInvalidFormat()
    {
        return array(
            array('11111111111', '111.111.111-11', 'AbC.111.111-11'),
            array('1111111111121', '222.222.222-22', '111.111.111-XX'),
            array('111.111.111A11', '333.333.111-11', '111.111.111-1c')
        );
    }

    public function providerInvalidChecksum()
    {
        return array(
            array('111.111.111-90'),
            array('111.111.121-70'),
            array('11145667898'),
            array('11145667899'),
        );
    }
}
