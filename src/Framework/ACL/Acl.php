<?php
namespace Framework\ACL;

/**
 * Created by PhpStorm.
 * User: HIEUTRIEU
 * Date: 9/30/2015
 * Time: 9:42 PM
 */
class Acl {
    /**
     * Roles Names
     *
     * @var mixed
     */
    protected $_rolesNames;

    /**
     * Roles
     *
     * @var mixed
     */
    protected $_roles;

    /**
     * Resource Names
     *
     * @var mixed
     */
    protected $_resourcesNames;

    /**
     * Resources
     *
     * @var mixed
     */
    protected $_resources;

    /**
     * Access
     *
     * @var mixed
     */
    protected $_access;

    /**
     * Role Inherits
     *
     * @var mixed
     */
    protected $_roleInherits;

    /**
     * Access List
     *
     * @var mixed
     */
    protected $_accessList;


    /**
     * ACL constructor
     */
    public function __construct() {}

    /**
     * Adds a role to the ACL list. Second parameter allows inheriting access data from other existing role
     * Example:
     * <code>
     * $acl->addRole(new Role('administrator'), 'consultant');
     * $acl->addRole('administrator', 'consultant');
     * </code>
     *
     * @param mixed $role
     * @param array|string $accessInherits
     * @return bool
     */
    public function addRole($role, $accessInherits = null) {
        if(is_object($role)) {
            $this->_rolesNames[$role->getName()] = 1;
            $this->_roles[] = $role;
        } else {
            $this->_rolesNames[$role] = 1;
            $this->_roles[] = new Role($role);
        }
    }

    /**
     * Do a role inherit from another existing role
     *
     * @param string $roleName
     * @param mixed $roleToInherit
     */
    public function addInherit($roleName, $roleToInherit) {}

    /**
     * Check whether role exist in the roles list
     *
     * @param string $roleName
     * @return bool
     */
    public function isRole($roleName) {
        return in_array($roleName, $this->_roles);
    }

    /**
     * Check whether resource exist in the resources list
     *
     * @param string $resourceName
     * @return bool
     */
    public function isResource($resourceName) {}

    /**
     * Adds a resource to the ACL list
     * Access names can be a particular action, by example
     * search, update, delete, etc or a list of them
     * Example:
     * <code>
     * //Add a resource to the the list allowing access to an action
     * $acl->addResource(new Resource('customers'), 'search');
     * $acl->addResource('customers', 'search');
     * //Add a resource  with an access list
     * $acl->addResource(new Resource('customers'), array('create', 'search'));
     * $acl->addResource('customers', array('create', 'search'));
     * </code>
     *
     * @param Resource|string $resourceValue
     * @param array|string $accessList
     * @return bool
     */
    public function addResource($resourceValue, $accessList) {
        if(is_object($resourceValue)) {
            $this->_resourcesNames[$resourceValue->getName()] = 1;
            $this->_resources[] = $resourceValue;
            $resourceName = $resourceValue->getName();
        } else {
            $this->_resourcesNames[$resourceValue] = 1;
            $this->_resources[] = new Resource($resourceValue);
            $resourceName = $resourceValue;
        }
        $this->addResourceAccess($resourceName, $accessList);
    }

    /**
     * Adds access to resources
     *
     * @param string $resourceName
     * @param array|string $accessList
     * @return bool
     */
    public function addResourceAccess($resourceName, $accessList) {
        foreach($this->_rolesNames as $roleName => $value) {
            if (is_array($accessList)) {
                foreach ($accessList as $index => $access) {
                    $this->_accessList[$resourceName . '!' . $access] = 1;
                    $this->_access[$roleName.'!'.$resourceName . '!' . $access] = 0;
                }
            } else {
                $this->_accessList[$resourceName . '!' . $accessList] = 1;
                $this->_access[$roleName.'!'.$resourceName . '!' . $accessList] = 0;
            }
        }
    }

    /**
     * Removes an access from a resource
     *
     * @param string $resourceName
     * @param array|string $accessList
     */
    public function dropResourceAccess($resourceName, $accessList) {}

    /**
     * Checks if a role has access to a resource
     *
     * @param string $roleName
     * @param string $resourceName
     * @param mixed $access
     * @param mixed $action
     */
    protected function _allowOrDeny($roleName, $resourceName, $access, $action) {}

    /**
     * Allow access to a role on a resource
     * You can use '*' as wildcard
     * Example:
     * <code>
     * //Allow access to guests to search on customers
     * $acl->allow('guests', 'customers', 'search');
     * //Allow access to guests to search or create on customers
     * $acl->allow('guests', 'customers', array('search', 'create'));
     * //Allow access to any role to browse on products
     * $acl->allow('*', 'products', 'browse');
     * //Allow access to any role to browse on any resource
     * $acl->allow('*', '*', 'browse');
     * </code>
     *
     * @param string $roleName
     * @param string $resourceName
     * @param mixed $access
     */
    public function allow($roleName, $resourceName, $access) {
        $accessName = $roleName.'!'.$resourceName.'!'.$access;
        $this->_access[$accessName] = 1;
    }

    /**
     * Deny access to a role on a resource
     * You can use '*' as wildcard
     * Example:
     * <code>
     * //Deny access to guests to search on customers
     * $acl->deny('guests', 'customers', 'search');
     * //Deny access to guests to search or create on customers
     * $acl->deny('guests', 'customers', array('search', 'create'));
     * //Deny access to any role to browse on products
     * $acl->deny('*', 'products', 'browse');
     * //Deny access to any role to browse on any resource
     * $acl->deny('*', '*', 'browse');
     * </code>
     *
     * @param string $roleName
     * @param string $resourceName
     * @param mixed $access
     */
    public function deny($roleName, $resourceName, $access) {
        $accessName = $roleName.'!'.$resourceName.'!'.$access;
        $this->_access[$accessName] = 0;
    }

    /**
     * Check whether a role is allowed to access an action from a resource
     * <code>
     * //Does andres have access to the customers resource to create?
     * $acl->isAllowed('andres', 'Products', 'create');
     * //Do guests have access to any resource to edit?
     * $acl->isAllowed('guests', '*', 'edit');
     * </code>
     *
     * @param string $roleName
     * @param string $resourceName
     * @param string $access
     * @return bool
     */
    public function isAllowed($roleName, $resourceName, $access) {
        $accessName = $roleName.'!'.$resourceName.'!'.$access;
        return $this->_access[$accessName];
    }

    /**
     * Return an array with every role registered in the list
     *
     * @return \Role[]
     */
    public function getRoles() {
        return $this->_roles;
    }

    /**
     * Return an array with every resource registered in the list
     *
     * @return \Resource[]
     */
    public function getResources() {
        return $this->_resources;
    }

}
