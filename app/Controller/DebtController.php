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

                return $app['twig']->render('debt/index.twig', array(
                                                                'user' => $user,
                                                               ));
            }
        );

        $controllers->get('/create',
            function () use ($app) {

                $users = $app['db.orm.em']->getRepository('Domain\User')->findAll();
                $currentUser = $app['db.orm.em']->getRepository('Domain\User')->findOneBy(array('username' => $app['session']->get('user')));

                return $app['twig']->render('debt/create.twig', array(
                                                                'users'       => $users,
                                                                'currentUser' => $currentUser,
                                                               ));
            }
        );

        $controllers->post('/create',
            function (\Symfony\Component\HttpFoundation\Request $request) use ($app) {

                $debitorId = $request->get('debitor');
                $creditorId = $request->get('creditor');
                $value = $request->get('value');

                $debitor = $app['db.orm.em']->getRepository('Domain\User')->find($debitorId);
                $creditor = $app['db.orm.em']->getRepository('Domain\User')->find($creditorId);

                $debt = new \Domain\Debt($value);
                $creditor->addCredit($debt);
                $debitor->addDebit($debt);

                $currentUser = $app['db.orm.em']->getRepository('Domain\User')->findOneBy(
                    array('username' => $app['session']->get('user'))
                );
                $debt->setActive($currentUser);

                $app['db.orm.em']->persist($debt);
                $app['db.orm.em']->flush();

                return $app->redirect('/');
            }
        );

        $controllers->post('/status',
            function (\Symfony\Component\HttpFoundation\Request $request) use ($app) {

                $currentUser = $app['db.orm.em']->getRepository('Domain\User')->findOneBy(
                    array('username' => $app['session']->get('user'))
                );

                $activateDebts = $request->get('activate', array());
                $deleteDebts = $request->get('delete', array());

                if ($deleteDebts) {

                    foreach ($deleteDebts as $debtId) {
                        $debt = $app['db.orm.em']->getRepository('Domain\Debt')->find($debtId);

                        $debt->setDelete($currentUser);
                        if ($debt->toDelete()) {
                            $debt->getCreditor()->getCredits()->removeElement($debt);
                            $debt->getDebitor()->getDebits()->removeElement($debt);
                            $app['db.orm.em']->remove($debt);
                        }
                    }
                }

                $app['db.orm.em']->flush();

                if ($activateDebts) {

                    $resolver = new \Domain\DebtResolver();

                    foreach ($activateDebts as $debtId) {
                        $debt = $app['db.orm.em']->getRepository('Domain\Debt')->find($debtId);
                        $debt->setActive($currentUser);
                        $resolver->resolve($currentUser, $app['db.orm.em']);
                        $resolver->resolve($debt->getCreditor(), $app['db.orm.em']);
                        $resolver->resolve($debt->getDebitor(), $app['db.orm.em']);
                    }
                }



                $app['db.orm.em']->flush();

                return $app->redirect('/');
            }
        );

        return $controllers;
    }
}