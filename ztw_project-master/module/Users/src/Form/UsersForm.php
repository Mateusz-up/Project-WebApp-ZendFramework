<?php

namespace Users\Form;

use Zend\Form\Form;

class UsersForm extends Form
{
    public function __construct($name = null)
    {
        // We will ignore the name provided to the constructor
        parent::__construct('users');

        $this->add([
            'name' => 'id',
            'type' => 'hidden',
        ]);
        $this->add([
            'name' => 'name',
            'type' => 'text',
            'options' => [
                'label' => 'name',
            ],
        ]);
        $this->add([
            'name' => 'surname',
            'type' => 'text',
            'options' => [
                'label' => 'surname',
            ],
        ]);
        $this->add([
            'name' => 'email',
            'type' => 'text',
            'options' => [
                'label' => 'email',
            ],
        ]);
        $this->add([
            'name' => 'role',
            'type' => 'select',
            'options' => [
                'label' => 'role',
                'options' => [
                    'wykładowca' => 'wykładowca',
                    'student' => 'student',
                    'admin' => 'admin',
                ]
            ],
        ]);
        $this->add([
            'name' => 'submit',
            'type' => 'submit',
            'attributes' => [
                'value' => 'Go',
                'id'    => 'submitbutton',
            ],
        ]);
    }
}