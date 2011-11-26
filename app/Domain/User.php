<?php
/**
 * Created by JetBrains PhpStorm.
 * User: fritze
 * Date: 26.11.11
 * Time: 00:03
 * To change this template use File | Settings | File Templates.
 */

namespace Domain;

/**
 * @Entity
 * @Table(name="user")
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


}
