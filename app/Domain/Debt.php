<?php
/**
 * Created by JetBrains PhpStorm.
 * User: fritze
 * Date: 26.11.11
 * Time: 10:52
 * To change this template use File | Settings | File Templates.
 */
namespace Domain;

/**
 * @Entity
 * @Table(name="Debt")
 */
class Debt {

    /**
     * @Id
     * @GeneratedValue
     * @Column(type="integer")
     */
    protected $id;

    /**
     * @Id
     * @ORM\ManyToOne(targetEntity="Domain\User", inversedBy="debits")
     * @ORM\JoinColumn(name="debitor_id", referencedColumnName="id")
     */
    protected $debitor;

    /**
     * @Id
     * @ORM\ManyToOne(targetEntity="Domain\User", inversedBy="credits")
     * @ORM\JoinColumn(name="creditor_id", referencedColumnName="id")
     */
    protected $creditor;

    protected $value;
/*
    public function __construct(User $debitor, User $creditor, $value) {

        $this->debitor = $debitor;
        $this->creditor = $creditor;
        $this->value = $value;
    }
*/
    /**
     * @param $value
     * @return Debt
     */
    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }

    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return \Domain\User
     */
    public function getCreditor()
    {
        return $this->creditor;
    }

    /**
     * @return \Domain\User
     */
    public function getDebitor()
    {
        return $this->debitor;
    }


}
