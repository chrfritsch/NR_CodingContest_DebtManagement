<?php
/**
 * Created by JetBrains PhpStorm.
 * User: christianfritsch
 * Date: 25.11.11
 * Time: 16:55
 * To change this template use File | Settings | File Templates.
 */

require_once __DIR__.'/silex.phar';
require_once __DIR__.'/config/config.inc.php';

use Symfony\Component\HttpFoundation\Response;

$app = new Silex\Application();

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path'       => __DIR__.'/views',
    'twig.class_path' => __DIR__.'/vendor/Twig/lib',
));

$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    'db.options' => array(
        'driver'   => 'pdo_mysql',
        'host'     => $config['production']['db']['host'],
        'dbname'   => $config['production']['db']['dbname'],
        'user'     => $config['production']['db']['user'],
        'password' => $config['production']['db']['password'],
    ),
    'db.dbal.class_path'    => __DIR__.'/vendor/doctrine2-orm/lib/vendor/doctrine-dbal/lib',
    'db.common.class_path'  => __DIR__.'/vendor/doctrine2-orm/lib/vendor/doctrine-common/lib',
));

$app['autoloader']->registerNamespace('Nutwerk', __DIR__.'/vendor/nutwerk-orm-extension/lib');
$app->register(new Nutwerk\Extension\DoctrineORMExtension(), array(
    'db.orm.class_path'            => __DIR__.'/vendor/doctrine2-orm/lib',
    'db.orm.proxies_dir'           => __DIR__.'/var/cache/Doctrine/Proxy',
    'db.orm.proxies_namespace'     => 'DoctrineProxy',
    'db.orm.auto_generate_proxies' => true,
    'db.orm.entities'              => array(array(
        'type'      => 'annotation',
        'path'      => __DIR__.'/app',
        'namespace' => 'Domain',
    )),
));
$app->register(new Silex\Provider\SessionServiceProvider());

$app['autoloader']->registerNamespace('Controller', __DIR__.'/app');
$app['autoloader']->registerNamespace('Domain', __DIR__.'/app');

$app->mount('/', new Controller\LoginController());
$app->mount('/debt/', new Controller\DebtController());

$app->get('/',
    function () use ($app) {

        /** @var $user Domain\User */
        if (null === $user = $app['session']->get('user')) {
            return $app->redirect('/index.php/login');
        }

        return $app['twig']->render('hello.twig', array(
            'name' => $user,
        ));
});

$app->run();

