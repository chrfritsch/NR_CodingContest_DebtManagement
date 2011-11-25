<?php
/**
 * Created by JetBrains PhpStorm.
 * User: christianfritsch
 * Date: 25.11.11
 * Time: 16:55
 * To change this template use File | Settings | File Templates.
 */
 
require_once __DIR__.'/silex.phar';

$app = new Silex\Application();

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path'       => __DIR__.'/views',
    'twig.class_path' => __DIR__.'/vendor/twig/lib',
));

$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    'db.options' => array(
        'driver'   => 'pdo_mysql',
        'host'     => 'c-fritsch.de',
        'dbname'   => 'd01287e8',
        'user'     => 'd01287e8',
        'password' => 'KwWUJZDFGvbUpoeP',
    ),
    'db.dbal.class_path'    => __DIR__.'/vendor/doctrine2-dbal/lib',
    'db.common.class_path'  => __DIR__.'/vendor/doctrine2-common/lib',
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

$app->get('/', function () use ($app) {


        
    return $app['twig']->render('hello.twig', array(
        'name' => 'hhh',
    ));
});

$app->get('/hello/{name}', function ($name) use ($app) {


        /** @var $em Doctrine\ORM\EntityManager */
        $app['db.orm.em'];
        
       $u = new Domain\User();
        $u->setId(2);
        $app['db.orm.em']->persist($u);
        $app['db.orm.em']->flush();
    return $app['twig']->render('hello.twig', array(
        'name' => $name,
    ));
});




$app->run();