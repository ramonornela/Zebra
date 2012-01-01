<?php
class Cpf_Callback
{
    public static function valid($cpf)
    {
        return '22222222222' === $cpf;
    }

    public function throwException()
    {
        new Exception('Throw exception cpf');
    }
}
