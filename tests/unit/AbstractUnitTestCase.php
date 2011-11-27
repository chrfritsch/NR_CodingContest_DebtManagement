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


abstract class AbstractUnitTestCase extends DoctrineExtensions\PHPUnit\OrmTestCase {

    protected $app;

    public function __construct() {

        include __DIR__.'/../../config/config.inc.php';

        parent::__construct();

        $this->app = new Silex\Application();
        $this->app['autoloader']->registerNamespace('Domain', __DIR__.'/../../app');

        $this->app->register(new Silex\Provider\DoctrineServiceProvider(), array(
            'db.options' => array(
                'driver'   => 'pdo_mysql',
                'host'     => $config['unittest']['db']['host'],
                'dbname'   => $config['unittest']['db']['dbname'],
                'user'     => $config['unittest']['db']['user'],
                'password' => $config['unittest']['db']['password'],
            ),
            'db.dbal.class_path'    => __DIR__.'/../../vendor/doctrine2-orm/lib/vendor/doctrine-dbal/lib',
            'db.common.class_path'  => __DIR__.'/../../vendor/doctrine2-orm/lib/vendor/doctrine-common/lib',
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

    /**
     * @return \Doctrine\ORM\EntityManager
     */
    protected function createEntityManager()
    {
        return $this->app['db.orm.em'];
    }

    /**
     * @return DoctrineExtensions\PHPUnit\DataSet\QueryDataSet|PHPUnit_Extensions_Database_DataSet_FlatXmlDataSet
     */
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
   #     $this->getDoctrineConnection()->executeQuery('TRUNCATE Debt');
    #    $this->getDoctrineConnection()->executeQuery('TRUNCATE User');
    }
}
