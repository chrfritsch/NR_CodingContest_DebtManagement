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

    /**
     * @param User $user
     * @param $em
     * @return void
     */
    public function resolve(User $user, $em) {

        foreach ($user->getCredits() as $credit) {
            foreach($user->getDebits() as $debit) {
                if ($credit->isActive() && $debit->isActive() && ($credit->getValue() == $debit->getValue())) {

                    $debit->getCreditor()->getCredits()->removeElement($debit);
                    $credit->getDebitor()->getDebits()->removeElement($credit);
                    $user->getCredits()->removeElement($credit);
                    $user->getDebits()->removeElement($debit);
                    $em->remove($debit);
                    $em->remove($credit);

                    break;

                } elseif ($credit->isActive() && $debit->isActive() && ($credit->getValue() > $debit->getValue())) {
                    
                    $credit->setValue($credit->getValue() - $debit->getValue());

                    $deb = new Debt($debit->getValue());
                    $credit->getDebitor()->addDebit($deb);
                    $debit->getCreditor()->addCredit($deb);
                    $deb->setActive($credit->getDebitor());
                    $deb->setActive($debit->getCreditor());
                    $em->persist($deb);

                    $user->getDebits()->removeElement($debit);
                    $em->remove($debit);
                    break;
                }
            }
            $em->flush();
        }

    }
}
