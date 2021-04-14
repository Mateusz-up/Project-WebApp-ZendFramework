<?php
namespace Groups\Form;

use Zend\Form\Form;

class GroupsForm extends Form
{
    public function __construct($name = null)
    {
        // We will ignore the name provided to the constructor
        parent::__construct('groups');

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
            'name' => 'course',
            'type' => 'text',
            'options' => [
                'label' => 'course',
            ],
        ]);
		$this->add([
            'name' => 'type',
            'type' => 'text',
            'options' => [
                'label' => 'type',
            ],
        ]);
	
		$this->add([
            'name' => 'year',
            'type' => 'number',
            'options' => [
                'label' => 'year',
            ],
        ]);
		$this->add([
            'name' => 'idlecturer',
            'type' => 'number',
            'options' => [
                'label' => 'idlecturer',
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

























