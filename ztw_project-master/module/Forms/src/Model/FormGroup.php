<?php
namespace Forms\Model;

use DomainException;

class FormGroup
{
    public $id;
    public $formid;
    public $groupid;

    public function exchangeArray(array $data)
    {
        $this->id     = !empty($data['id']) ? $data['id'] : null;
        $this->formid = !empty($data['formid']) ? $data['formid'] : null;
        $this->groupid  = !empty($data['groupid']) ? $data['groupid'] : null;
    }

    public function getArrayCopy()
    {
        return [
            'id' => $this->id,
            'formid' => $this->formid,
            'groupid'  => $this->groupid
        ];
    }

    public function setInputFilter(InputFilterInterface $inputFilter)
     {
         throw new DomainException(sprintf(
             '%s does not allow injection of an alternate input filter',
             __CLASS__
         ));
     }




}
?>
