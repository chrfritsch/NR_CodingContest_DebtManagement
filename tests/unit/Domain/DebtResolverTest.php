<?php
/**
 * Created by JetBrains PhpStorm.
 * User: fritze
 * Date: 26.11.11
 * Time: 11:02
 * To change this template use File | Settings | File Templates.
 */
 require_once 'AbstractUnitTestCase.php';


class DebtResolverTest extends AbstractUnitTestCase
{
    public function testSimpleExample()
    {
        $a = $this->getEntityManager()->getRepository('Domain\User')->find(1);
        $b = $this->getEntityManager()->getRepository('Domain\User')->find(2);
        $c = $this->getEntityManager()->getRepository('Domain\User')->find(3);

        $de = $this->getEntityManager()->getRepository('Domain\Debt')->find(1);

        var_dump($a);
        var_dump($de);

        $resolver = new Domain\DebtResolver();
        $resolver->resolve($b, $this->getEntityManager());

        foreach($a->getDebits() as $debit) {
            var_dump($debit->getValue());
        }

    }
}