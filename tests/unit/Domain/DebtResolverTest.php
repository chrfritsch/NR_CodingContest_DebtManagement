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
    public function testResolveConnectionCreditGreaterDebit()
    {
        /** @var $a \Domain\User */
        $a = $this->getEntityManager()->getRepository('Domain\User')->find(1);
        $b = $this->getEntityManager()->getRepository('Domain\User')->find(2);
        $c = $this->getEntityManager()->getRepository('Domain\User')->find(3);

        $this->assertEquals(1, count($a->getDebits()));

        $resolver = new Domain\DebtResolver();
        $resolver->resolve($b, $this->getEntityManager());

        $this->assertEquals(2, count($a->getDebits()));

        $debit1 = $a->getDebits()->get(0);
        $debit2 = $a->getDebits()->get(1);

        $this->assertEquals('b', $debit1->getCreditor()->getUsername());
        $this->assertEquals(1, $debit1->getValue());
        $this->assertEquals('c', $debit2->getCreditor()->getUsername());
        $this->assertEquals(2, $debit2->getValue());

        $this->assertEquals(0, count($b->getDebits()));
        $this->assertEquals(0, count($c->getDebits()));

        $this->assertEquals(1, count($b->getCredits()));
        $this->assertEquals(1, count($c->getCredits()));

    }

    public function testResolveConnectionCreditEqualsDebit()
    {
        /** @var $a \Domain\User */
        $a = $this->getEntityManager()->getRepository('Domain\User')->find(1);
        $b = $this->getEntityManager()->getRepository('Domain\User')->find(2);
        $c = $this->getEntityManager()->getRepository('Domain\User')->find(3);

        $this->assertEquals(1, count($a->getDebits()));
        $this->assertEquals(1, count($b->getDebits()));
        $this->assertEquals(1, count($b->getCredits()));
        $this->assertEquals(1, count($c->getCredits()));

        $resolver = new Domain\DebtResolver();
        $resolver->resolve($b, $this->getEntityManager());

        foreach($a->getDebits() as $debit){
            var_dump($debit->getValue());
        }

        $this->assertEquals(0, count($a->getDebits()));
        $this->assertEquals(0, count($b->getDebits()));
        $this->assertEquals(0, count($c->getDebits()));

        $this->assertEquals(0, count($a->getCredits()));
        $this->assertEquals(0, count($b->getCredits()));
        $this->assertEquals(0, count($c->getCredits()));

    }


}