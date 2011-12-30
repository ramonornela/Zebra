<?php
require_once 'PHPUnit/Runner/Version.php';
$phpunitVersion = PHPUnit_Runner_Version::id();
if ($phpunitVersion !== '@package_version@' &&
    -1 === version_compare($phpunitVersion, '3.5.0'))
{
    echo 'Está versão do PHPUnit não é suportada pelo Zebra.';
    exit(1);
}

require_once 'PHPUnit/Autoload.php';
error_reporting(E_ALL | E_STRICT);
$paths = array(
    realpath(dirname(dirname(__FILE__))) . '/library',
    get_include_path()
);

set_include_path(implode(PATH_SEPARATOR, $paths));

require_once 'Zend/Loader/Autoloader.php';
Zend_Loader_Autoloader::getInstance()
    ->registerNamespace('Zebra');