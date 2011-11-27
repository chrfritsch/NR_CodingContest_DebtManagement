<?php
/**
 * Created by JetBrains PhpStorm.
 * User: fritze
 * Date: 26.11.11
 * Time: 11:10
 * To change this template use File | Settings | File Templates.
 */
 
require_once __DIR__.'/../../silex.phar';

use Symfony\Component\ClassLoader\UniversalClassLoader;

$loader = new UniversalClassLoader();
$loader->registerNamespaces(array(
    'DoctrineExtensions' =>  __DIR__.'/../../vendor/DoctrineExtensions/lib',
));
$loader->register();

