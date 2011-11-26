<?php
/**
 * Created by JetBrains PhpStorm.
 * User: fritze
 * Date: 26.11.11
 * Time: 08:50
 * To change this template use File | Settings | File Templates.
 */

namespace Controller;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Silex\ControllerCollection;

class DebtController implements ControllerProviderInterface
{
    public function connect(Application $app) {


        $controllers = new ControllerCollection();

        $controllers->get('/',
            function () use ($app) {

                $username = $app['session']->get('user');
                /** @var $user \Domain\User */
                $user = $app['db.orm.em']->getRepository('Domain\User')->findOneBy(array('username' => $username));

                var_dump($user->getCredits());



                return $app['twig']->render('debt/index.twig', array());
            }
        );


        return $controllers;
    }
}