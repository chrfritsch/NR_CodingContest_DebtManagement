<?php
/**
 * Created by JetBrains PhpStorm.
 * User: fritze
 * Date: 26.11.11
 * Time: 11:02
 * To change this template use File | Settings | File Templates.
 */
 require_once 'phpunit.inc.php';

/**
 * @backupGlobals disabled
 */
class DebtTest extends PHPUnit_Framework_TestCase
{
    public function testGetterSetter()
    {
        $u1 = new Domain\User();
        $u2 = new Domain\User();

        $debt = new \Domain\Debt($u1, $u2, 10);
        $this->assertEquals(10, $debt->getValue());

    }
}