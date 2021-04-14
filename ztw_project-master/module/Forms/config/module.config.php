<?php
namespace Forms;

use Zend\Router\Http\Segment;

return [
    'router' => [
        'routes' => [
            'forms' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/forms[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\FormsController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],

    'view_manager' => [
        'template_path_stack' => [
            'forms' => __DIR__ . '/../view',
        ],
    ],
];

?>
