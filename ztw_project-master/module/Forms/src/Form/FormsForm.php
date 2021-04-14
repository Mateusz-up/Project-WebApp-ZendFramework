<?php
namespace Forms\Form;

use Zend\Form\Form;

class FormsForm extends Form
{
    public function __construct($name = null)
    {
        // We will ignore the name provided to the constructor
        parent::__construct('forms');

        $this->add([
            'name' => 'id',
            'type' => 'hidden',
        ]);
        $this->add([
            'name' => 'name',
            'type' => 'text',
            'options' => [
                'label' => 'Name',
            ],
        ]);
        $this->add([
            'name' => 'dateadd',
            'type' => 'text',
            'options' => [
                'label' => 'DateAdd',
            ],
        ]);
        $this->add([
            'name' => 'author',
            'type' => 'text',
            'options' => [
                'label' => 'Author',
            ],
        ]);
        $this->add([
            'name' => 'status',
            'type' => 'text',
            'options' => [
                'label' => 'Status',
            ],
        ]);

         $this->add([
             'type' => 'Zend\Form\Element\MultiCheckbox',
             'name' => 'groups',
             'options' => [
                'label' => 'Groups',
                'column-size' => 'sm-10',
                'label_attributes' => array('class' => 'col-sm-3'),
                'twb-layout' => 'horizontal',
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
