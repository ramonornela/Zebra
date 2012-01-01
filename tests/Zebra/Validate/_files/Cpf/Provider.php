<?php
class Cpf_Provider
{
    final public static function construtor()
    {
        return array(
            array(1, 1),
            array(array('separatorMode' => 2), 2),
            array(new Zend_Config(array('separatorMode' => 1)), 1),
            array('clean', 2),
            array(array('separatorMode' => 2, 'service' => 'strtolower'), 2, 'strtolower'),
        );
    }

    final public static function invalidMode()
    {
        return array(
            array(null),
            array(4),
            array(array(-3, -2))
        );
    }

    final public static function invalidChecksum()
    {
        return array(
            array('111.111.111-90'),
            array('111.111.121-70'),
            array('11145667898'),
            array('11145667899'),
        );
    }

    final public static function invalidFormat()
    {
        return array(
            array(
                array('mode' => 'separator', 'cpf' => '11111111111')
            ),
            array(
                array('mode' => 'clean',     'cpf' => '111.111.111-11')
            ),
            array(
                array('mode' => 'auto',      'cpf' => 'AbC.111.111-11')
            ),
            array(
                array('mode' => 'separator', 'cpf' => '1111111111121')
            ),
            array(
                array('mode' => 'clean',     'cpf' => '222.222.222-22')
            ),
            array(
                array('mode' => 'auto',      'cpf' =>  '111.111.111-XX')
            ),
            array(
                array('mode' => 'separator', 'cpf' => '111.111.111A11')
            ),
            array(
                array('mode' => 'clean',     'cpf' => '333.333.111-11')
            ),
            array(
                array('mode' => 'auto',      'cpf' => '111.111.111-1c')
            )
        );
    }

    final public static function valids()
    {
        return array(
            array(
                array(
                    'mode' => 'auto',
                    'cpf'  => array(
                        array(
                            'value' => '111.111.111-11',
                            'bool'  => true,
                        ),
                        array(
                            'value' => '11111111111',
                            'bool'  => true,
                        )
                    )
                )
            ),
            array(
                array(
                    'mode' => 'clean',
                    'cpf'  => array(
                        array(
                            'value' => '11111111111',
                            'bool'  => true,
                        ),
                        array(
                            'value' => '111.111.111-11',
                            'bool'  => false,
                        )
                    )
                )
            ),
            array(
                array(
                    'mode' => 'separator',
                    'cpf'  => array(
                        array(
                            'value' => '222.222.222-22',
                            'bool'  => true,
                        ),
                        array(
                            'value' => '22222222222',
                            'bool'  => false,
                        )
                    )
                )
            )
        );
    }
}
