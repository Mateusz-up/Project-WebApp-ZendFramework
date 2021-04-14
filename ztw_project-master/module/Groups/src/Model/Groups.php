<?php
namespace Groups\Model;

use DomainException;
use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\Filter\ToInt;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Zend\Validator\StringLength;

class Groups
{
    public $id;
    public $name;
    public $course;
    public $year;
    public $type;
    public $idlecturer;
	
	 private $inputFilter;

    public function exchangeArray(array $data)
    {
        $this->id     = !empty($data['id']) ? $data['id'] : null;
        $this->name = !empty($data['name']) ? $data['name'] : null;
        $this->course  = !empty($data['course']) ? $data['course'] : null;
        $this->year  = !empty($data['year']) ? $data['year'] : null;
        $this->type  = !empty($data['type']) ? $data['type'] : null;
        $this->idlecturer  = !empty($data['idlecturer']) ? $data['idlecturer'] : null;
    }
	
	 public function getArrayCopy()
    {
        return [
            'id'     => $this->id,
            'name' => $this->name,
            'course'  => $this->course,
			 'year'  => $this->year,
			  'type'  => $this->type,
			   'idlecturer'  => $this->idlecturer,
        ];
    }
	
	public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new DomainException(sprintf(
            '%s does not allow injection of an alternate input filter',
            __CLASS__
        ));
    }
	 
	 public function getInputFilter()
    {
        if ($this->inputFilter) {
            return $this->inputFilter;
        }

        $inputFilter = new InputFilter();

        $inputFilter->add([
            'name' => 'id',
            'required' => true,
            'filters' => [
                ['name' => ToInt::class],
            ],
        ]);

        $inputFilter->add([
            'name' => 'name',
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validators' => [
                [
                    'name' => StringLength::class,
                    'options' => [
                        'encoding' => 'UTF-8',
                        'min' => 1,
                        'max' => 100,
                    ],
                ],
            ],
        ]);

        $inputFilter->add([
            'name' => 'course',
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validators' => [
                [
                    'name' => StringLength::class,
                    'options' => [
                        'encoding' => 'UTF-8',
                        'min' => 1,
                        'max' => 100,
                    ],
                ],
            ],
        ]);
		
		 $inputFilter->add([
            'name' => 'type',
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validators' => [
                [
                    'name' => StringLength::class,
                    'options' => [
                        'encoding' => 'UTF-8',
                        'min' => 1,
                        'max' => 100,
                    ],
                ],
            ],
        ]);
		
		
		
        $inputFilter->add([
            'name'       => 'year',
            'required'   => true,
            'filters'    => [
                ['name' => 'int'],
            ],
        ]);
		
		
        $inputFilter->add([
            'name'       => 'idlecturer',
            'required'   => true,
            'filters'    => [
                ['name' => 'int'],
            ],
        ]);

        $this->inputFilter = $inputFilter;
        return $this->inputFilter;
    }
	
	
}
?>
