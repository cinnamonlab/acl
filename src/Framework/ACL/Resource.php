<?php

namespace Framework\ACL;

/**
 * Created by PhpStorm.
 * User: HIEUTRIEU
 * Date: 9/30/2015
 * Time: 9:42 PM
 */

class Resource implements ResourceInterface
{
    /**
     * Resource name
     *
     * @var string
     */
    protected $_name;

    /**
     * Resource description
     *
     * @var string
     */
    protected $_description;


    /**
     * Resource name
     *
     * @return string 
     */
	public function getName() {
        return $this->_name;
    }

    /**
     * Resource name
     */
	public function __toString() {}

    /**
     * Resource description
     *
     * @return string 
     */
	public function getDescription() {
        return $this->_description;
    }

    /**
     * Framework\ACL\Resource constructor
     *
     * @param string $name 
     * @param string $description 
     */
	public function __construct($name, $description = null) {
        $this->_name = $name;
        $this->_description = $description;
    }

}
