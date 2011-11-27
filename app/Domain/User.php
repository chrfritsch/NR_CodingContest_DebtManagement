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
 * @ORM\Table(name="User")
 */
class User {

    /**
     * @Id
     * @GeneratedValue
     * @Column(type="integer")
     */
    protected $id;

    /**
     * @Column(name="username")
     * @var string
     */
    protected $username;

    /**
     * @Column(name="password")
     * @var string
     */
    protected $password;

    /**
     * @Column(name="forename")
     * @var string
     */
    protected $forename;

    /**
     * @Column(name="surname")
     * @var string
     */
    protected $surname;

    /**
     * @OneToMany(targetEntity="Debt", mappedBy="creditor")
     * @var ArrayCollection
     */
    protected $credits;

    /**
     * @OneToMany(targetEntity="Debt", mappedBy="debitor")
     * @var ArrayCollection
     */
    protected $debits;

    public function __construct() {
        $this->credits = new ArrayCollection();
        $this->debits = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $forename
     * @return User
     */
    public function setForename($forename)
    {
        $this->forename = $forename;
        return $this;
    }

    /**
     * @return string
     */
    public function getForename()
    {
        return $this->forename;
    }

    /**
     * @param string $password
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $surname
     * @return User
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;
        return $this;
    }

    /**
     * @return string
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * @param string $username
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection|ArrayCollection
     */
    public function getCredits()
    {
        return $this->credits;
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getDebits()
    {
        return $this->debits;
    }

    /**
     * @param Debt $debt
     * @return User
     */
    public function addCredit(Debt $debt) {
        $debt->setCreditor($this);
        $this->credits->add($debt);
        return $this;
    }

    /**
     * @param Debt $debt
     * @return User
     */
    public function addDebit(Debt $debt) {
        $debt->setDebitor($this);
        $this->debits->add($debt);
        return $this;
    }

}
