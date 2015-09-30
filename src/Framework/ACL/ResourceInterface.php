<?php

namespace Framework\ACL;

interface ResourceInterface
{

    /**
     * Framework\ACL\ResourceInterface constructor
     *
     * @param string $name 
     * @param mixed $description 
     */
	public function __construct($name, $description = null);

    /**
     * Returns the resource name
     *
     * @return string 
     */
	public function getName();

    /**
     * Returns resource description
     *
     * @return string 
     */
	public function getDescription();

    /**
     * Magic method __toString
     *
     * @return string 
     */
	public function __toString();

}
