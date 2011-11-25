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

    /** @Id @Column(type="integer") */
    protected $id;


    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }
}
