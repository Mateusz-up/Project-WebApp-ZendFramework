<?php

namespace Groups;

use Zend\Router\Http\Segment;


return [

    // The following section is new and should be added to your file:
    'router' => [
        'routes' => [
            'groups' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/groups[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\GroupsController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],

    'view_manager' => [
        'template_path_stack' => [
            'groups' => __DIR__ . '/../view',
        ],
    ],
];