<?php
namespace Forms\Model;

use DomainException;
use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\Filter\ToInt;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Zend\Validator\StringLength;

class Forms
{
    public $id;
    public $name;
    public $dateadd;
    public $author;
    public $status;
    public $groups;

    private $inputFilter;

    public function exchangeArray(array $data)
    {
        $this->id     = !empty($data['id']) ? $data['id'] : null;
        $this->name = !empty($data['name']) ? $data['name'] : null;
        $this->dateadd  = !empty($data['dateadd']) ? $data['dateadd'] : null;
        $this->author  = !empty($data['author']) ? $data['author'] : null;
        $this->status  = !empty($data['status']) ? $data['status'] : null;
        $this->groups  = !empty($data['groups']) ? $data['groups'] : null;

    }

    public function getArrayCopy()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'dateadd'  => $this->dateadd,
            'author'  => $this->author,
            'status'  => $this->status,
            'groups' => $this->groups
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
             'name' => 'dateadd',
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
            'name' => 'author',
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
            'name' => 'status',
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
