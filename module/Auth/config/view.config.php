<?php

use Zend\View\HelperPluginManager;

return [
    'view_manager' => [
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ],
    'view_helpers' => [
        'factories' => [
            'identity' => function (HelperPluginManager $hpm) {
                    $sm = $hpm->getServiceLocator();
                    /** @var \Auth\Storage\DbStorage $storage */
                    $storage = $sm->get(\Auth\Storage\DbStorage::class);
                    $authentication = new \Zend\Authentication\AuthenticationService($storage);

                    $identity = new \Zend\View\Helper\Identity();
                    $identity->setAuthenticationService($authentication);


                    return $identity;
                }
        ]
    ],
];