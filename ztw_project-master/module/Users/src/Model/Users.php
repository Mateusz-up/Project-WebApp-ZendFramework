<?php
namespace Users\Model;

// Add the following import statements:
use DomainException;
use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\Filter\ToInt;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Zend\Validator\StringLength;

class Users
{
    public $id;
    public $name;
    public $surname;
    public $email;
    public $role;

    // Add this property:
    private $inputFilter;

    public function exchangeArray(array $data)
    {
        $this->id     = !empty($data['id']) ? $data['id'] : null;
        $this->name = !empty($data['name']) ? $data['name'] : null;
        $this->surname  = !empty($data['surname']) ? $data['surname'] : null;
        $this->email  = !empty($data['email']) ? $data['email'] : null;
        $this->role  = !empty($data['role']) ? $data['role'] : null;
    }

    public function getArrayCopy()
    {
        return [
            'id'     => $this->id,
            'name' => $this->name,
            'surname'  => $this->surname,
            'email'  => $this->email,
            'role'  => $this->role
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
             'name' => 'surname',
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
            'name' => 'email',
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
            'name' => 'role',
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
 
         $this->inputFilter = $inputFilter;
         return $this->inputFilter;
     }
}
?>