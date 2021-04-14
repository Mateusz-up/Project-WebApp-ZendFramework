<?php

namespace Questions;

use Zend\Router\Http\Segment;


return [
    // The following section is new and should be added to your file:
    'router' => [
        'routes' => [
            'questions' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/questions[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\QuestionsController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],

    'view_manager' => [
        'template_path_stack' => [
            'questions' => __DIR__ . '/../view',
        ],
    ],
];
