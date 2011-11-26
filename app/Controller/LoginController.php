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

class LoginController implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        $controllers = new ControllerCollection();

        $controllers->get('/login',
            function () use ($app) {
                return $app['twig']->render('login.twig', array());
            }
        );

        $controllers->post('/login',
            function (\Symfony\Component\HttpFoundation\Request $request) use ($app) {

                $username = $request->get('username');
                $password = $request->get('password');

                /** @var $user Domain\User */
                $user = $app['db.orm.em']->getRepository('Domain\User')->findOneBy(array('username' => $username));


                if ($user == null) {
                    return $app->redirect('/index.php/register');
                } elseif ($user->getPassword() == sha1($password)) {
                    $app['session']->set('user', $username);
                }

                return $app->redirect('/');
            }
        );

        $controllers->get('/register',
            function () use ($app) {
                return $app['twig']->render('register.twig', array());
            }
        );

        $controllers->post('/register',
            function (\Symfony\Component\HttpFoundation\Request $request) use ($app) {

                $username = $request->get('username');
                $password = $request->get('password');
                $forename = $request->get('forename');
                $surname = $request->get('surname');

                $user = new Domain\User();
                $user->setUsername($username)
                    ->setPassword(sha1($password))
                    ->setForename($forename)
                    ->setSurname($surname);

                $app['db.orm.em']->persist($user);
                $app['db.orm.em']->flush();

                return $app->redirect('/');
            }
        );

        $controllers->get('/logout',
            function () use ($app) {

                $app['session']->clear();
                return $app->redirect('/');
            }
);

        return $controllers;
    }
}