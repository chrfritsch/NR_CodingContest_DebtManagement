<?php
/**
 * Created by JetBrains PhpStorm.
 * User: fritze
 * Date: 26.11.11
 * Time: 11:22
 * To change this template use File | Settings | File Templates.
 */
namespace Domain;

class DebtResolver {

    public function resolve(User $user, $em) {

        foreach ($user->getCredits() as $credit) {
            foreach($user->getDebits() as $debit) {
                if ($credit->getValue() == $debit->getValue()) {
                    $em->remove($debit);
                    var_dump('Delete:'. $debit->getValue());
                    var_dump('Delete:'. $credit->getValue());

                    $em->remove($credit);

                    break;

                } elseif ($credit->getValue() > $debit->getValue()) {
                    $credit->setValue($credit->getValue() - $debit->getValue());
                    $em->remove($debit);

                    var_dump($credit->getDebitor()->getUsername());
var_dump($debit->getCreditor()->getUsername());
                    $deb = new Debt($credit->getDebitor(), $debit->getCreditor(), $debit->getValue() - $credit->getValue());
                    $credit->getDebitor()->getDebits()->add($deb);
                    $debit->getCreditor()->getCredits()->add($deb);


                    break;
                }
            }
            $em->flush();
        }

    }

}
