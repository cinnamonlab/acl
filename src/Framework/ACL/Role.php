<?php

namespace Framework\ACL;

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
	public function getName() {}

    /**
     * Role name
     */
	public function __toString() {}

    /**
     * Role description
     *
     * @return string 
     */
	public function getDescription() {}

    /**
     * Framework\Acl\Role constructor
     *
     * @param string $name 
     * @param string $description 
     */
	public function __construct($name, $description = null) {}

}
