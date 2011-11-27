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
     * @var int
     */
    protected $id;

    /**
     * @ManyToOne(targetEntity="User", inversedBy="debits")
     * @JoinColumn(name="debitor_id", referencedColumnName="id")
     * @var User
     */
    protected $debitor;

    /**
     * @ManyToOne(targetEntity="User", inversedBy="credits")
     * @JoinColumn(name="creditor_id", referencedColumnName="id")
     * @var User
     */
    protected $creditor;

    /**
     * @Column(type="integer")
     * @var int
     */
    protected $value;

    /**
     * @Column(type="integer")
     * @var integer
     */
    protected $active;

    /**
     * @Column(type="integer", name="toDelete")
     * @var integer
     */
    protected $delete;

    public function __construct($value) {

        $this->value = $value;
        $this->delete = 0;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $value
     * @return Debt
     */
    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }

    /**
     * @return int
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param User $creditor
     * @return Debt
     */
    public function setCreditor(User $creditor)
    {
        $this->creditor = $creditor;
        return $this;
    }

    /**
     * @return User
     */
    public function getCreditor()
    {
        return $this->creditor;
    }

    /**
     * @param User $debitor
     * @return Debt
     */
    public function setDebitor(User $debitor)
    {
        $this->debitor = $debitor;
        return $this;
    }

    /**
     * @return User
     */
    public function getDebitor()
    {
        return $this->debitor;
    }

    /**
     * @param User $user
     * @return Debt
     */
    public function setActive(User $user)
    {
        if ($this->active != $user->getId()) {
            $this->active += $user->getId();
        }
        return $this;
    }

    /**
     * @return boolean
     */
    public function isActive()
    {
        return ($this->active == ($this->creditor->getId() + $this->debitor->getId()));
    }

    public function activeStatus() {
        return $this->active;
    }
    /**
     * @param User $user
     * @return Debt
     */
    public function setDelete(User $user)
    {
        if ($this->delete != $user->getId()) {
            $this->delete += $user->getId();
        }
        return $this;
    }

    /**
     * @return boolean
     */
    public function toDelete()
    {
        return ($this->delete == ($this->creditor->getId() + $this->debitor->getId()));
    }

    /**
     * @return int
     */
    public function deleteStatus() {
        return $this->delete;
    }
}
