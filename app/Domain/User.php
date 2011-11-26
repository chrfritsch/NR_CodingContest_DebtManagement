<?php
/**
 * Created by JetBrains PhpStorm.
 * User: fritze
 * Date: 26.11.11
 * Time: 00:03
 * To change this template use File | Settings | File Templates.
 */

namespace Domain;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity
 * @Table(name="User")
 */
class User {

    /**
     * @Id
     * @GeneratedValue
     * @Column(type="integer")
     */
    protected $id;

    /** @Column(name="username") */
    protected $username;

    /** @Column(name="password") */
    protected $password;

    /** @Column(name="forename") */
    protected $forename;

    /** @Column(name="surname") */
    protected $surname;

    /**
     * @ORM\OneToMany(targetEntity="Debt", mappedBy="creditor",cascade={"ALL"}, indexBy="credits")
     */
    protected $credits;

    /**
     * @ORM\OneToMany(targetEntity="Debt", mappedBy="debitor",cascade={"ALL"}, indexBy="debits")
     */
    protected $debits;

    public function __construct() {
        $this->credits = new ArrayCollection();
        $this->debits = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function setForename($forename)
    {
        $this->forename = $forename;
        return $this;
    }

    public function getForename()
    {
        return $this->forename;
    }

    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setSurname($surname)
    {
        $this->surname = $surname;
        return $this;
    }

    public function getSurname()
    {
        return $this->surname;
    }

    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setCredits($credits)
    {
        $this->credits = $credits;
    }

    public function getCredits()
    {
        return $this->credits;
    }

    public function setDebits($debits)
    {
        $this->debits = $debits;
    }

    public function getDebits()
    {
        return $this->debits;
    }


}
