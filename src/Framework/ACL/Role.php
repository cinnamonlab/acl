<?php

namespace Framework\ACL;

/**
 * Created by PhpStorm.
 * User: HIEUTRIEU
 * Date: 9/30/2015
 * Time: 9:42 PM
 */
class Role implements RoleInterface
{
    /**
     * Role name
     *
     * @var string
     */
    protected $_name;

    /**
     * Role description
     *
     * @var string
     */
    protected $_description;


    /**
     * Role name
     *
     * @return string 
     */
	public function getName() {
        return $this->_name;
    }

    /**
     * Role name
     */
	public function __toString() {}

    /**
     * Role description
     *
     * @return string 
     */
	public function getDescription() {
        return $this->_description;
    }

    /**
     * Framework\Acl\Role constructor
     *
     * @param string $name 
     * @param string $description 
     */
	public function __construct($name, $description = null) {
        $this->_name = $name;
        $this->_description = $description;
    }

}
