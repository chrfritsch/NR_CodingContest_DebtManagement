<?php
/**
 * Created by JetBrains PhpStorm.
 * User: fritze
 * Date: 26.11.11
 * Time: 13:16
 * To change this template use File | Settings | File Templates.
 */

require_once __DIR__.'/phpunit.inc.php';

use DoctrineExtensions\PHPUnit\DataSet\QueryDataSet;


abstract class AbstractUntiTestCase extends DoctrineExtensions\PHPUnit\OrmTestCase {

    protected $app;

    public function __construct() {

        parent::__construct();

        $this->app = new Silex\Application();
        $this->app['autoloader']->registerNamespace('Domain', __DIR__.'/../../app');

        $this->app->register(new Silex\Provider\DoctrineServiceProvider(), array(
            'db.options' => array(
                'driver'   => 'pdo_mysql',
                'host'     => 'c-fritsch.de',
                'dbname'   => 'd01287e8',
                'user'     => 'd01287e8',
                'password' => 'KwWUJZDFGvbUpoeP',
            ),
            'db.dbal.class_path'    => __DIR__.'/../../vendor/doctrine2-dbal/lib',
            'db.common.class_path'  => __DIR__.'/../../vendor/doctrine2-common/lib',
        ));

        $this->app['autoloader']->registerNamespace('Nutwerk', __DIR__.'/../../vendor/nutwerk-orm-extension/lib');
        $this->app->register(new Nutwerk\Extension\DoctrineORMExtension(), array(
            'db.orm.class_path'            => __DIR__.'/../../vendor/doctrine2-orm/lib',
            'db.orm.proxies_dir'           => __DIR__.'/../../var/cache/Doctrine/Proxy',
            'db.orm.proxies_namespace'     => 'DoctrineProxy',
            'db.orm.auto_generate_proxies' => true,
            'db.orm.entities'              => array(array(
                'type'      => 'annotation',
                'path'      => __DIR__.'/../../app',
                'namespace' => 'Domain',
            )),
        ));

        $this->app['autoloader']->registerNamespace('DoctrineExtensions', __DIR__.'/../../vendor/DoctrineExtensions/lib');


    }

    protected function createEntityManager()
    {
        return $this->app['db.orm.em'];
    }

    protected function getDataSet()
    {
        $filename = dirname(__FILE__) . '/../_fixtures/'. get_class($this). '/' .
                    $this->getName() . '.xml';

        if (file_exists($filename)) {
            return $this->createFlatXMLDataSet($filename);
        } else {
            return new QueryDataSet($this->getConnection());
        }
    }

    public function tearDown()
    {
        parent::tearDown();
        $this->getDoctrineConnection()->executeQuery('TRUNCATE User');
        $this->getDoctrineConnection()->executeQuery('TRUNCATE Debt');
    }
}