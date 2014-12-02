<?php

namespace Acl\Service;

use Zend\Permissions\Acl\Acl;
use Zend\Permissions\Acl\Role\GenericRole;

class AclFactory
{
    /**
     * @var array
     */
    private $modules;

    /**
     * @var array
     */
    private $config;

    public function __construct(array $modules, array $config)
    {
        $this->modules = $modules;
        $this->config = $config;
    }

    /**
     * @return Acl
     */
    public function create()
    {
        $acl = new Acl();

        $this->addResources($acl);
        $this->addRoles($acl);
        $this->addAllowAndDeny($acl);

        return $acl;
    }

    private function addResources(Acl $acl)
    {
        foreach ($this->modules as $module) {
            if (!$acl->hasResource($module)) {
                $acl->addResource(strtolower($module));
            }
        }
    }

    private function addRoles(Acl $acl)
    {
        foreach ($this->config as $roleName => $roleConfig) {
            $parents = isset($roleConfig['parents']) ? $roleConfig['parents'] : [];
            $parents = array_map('strtolower', $parents);
            $acl->addRole(new GenericRole(strtolower($roleName)), $parents);
        }
    }

    private function addAllowAndDeny(Acl $acl)
    {
        foreach ($this->config as $roleName => $roleConfig) {
            $allowList = isset($roleConfig['allow']) ? $roleConfig['allow'] : [];
            foreach ($allowList as $resource => $privilegeList) {
                if (empty($privilegeList)) {
                    $acl->allow($roleName, strtolower($resource));
                } else {
                    foreach ((array)$privilegeList as $privilege) {
                        $acl->allow($roleName, strtolower($resource), strtolower($privilege));
                    }
                }
            }

            $denyList = isset($roleConfig['deny']) ? $roleConfig['deny'] : [];
            foreach ($denyList as $resource => $privilegeList) {
                if (empty($privilegeList)) {
                    $acl->deny($roleName, strtolower($resource));
                } else {
                    foreach ((array)$privilegeList as $privilege) {
                        $acl->deny($roleName, strtolower($resource), strtolower($privilege));
                    }
                }
            }
        }
    }

}