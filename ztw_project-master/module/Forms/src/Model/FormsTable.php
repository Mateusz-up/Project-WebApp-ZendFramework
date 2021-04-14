<?php
namespace Forms\Model;

use RuntimeException;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\TableGatewayInterface;

class FormsTable
{
    private $tableGateway;

    public function __construct(TableGatewayInterface $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll()
    {
        $resultSet= $this->tableGateway->select();
		return $resultSet;
    }

    public function getForms($id)
    {
        $id = (int) $id;
        $sqlSelect = $this->tableGateway->getSql()->select()->where(['forms.id' => $id]);
        $sqlSelect->columns(array('*'));
        $sqlSelect->join('formgroup', 'forms.id = formgroup.formid', array('groups'=>'groupid'), 'left');
		$rowset = $this->tableGateway->selectWith($sqlSelect);

        $row = $rowset->current();

        if (! $row) {
            throw new RuntimeException(sprintf(
                'Could not find row with identifier %d',
                $id
            ));
        }

        return $row;
    }

    public function saveForms(Forms $forms)
    {

        $data = [
            'name' => $forms->name,
            'dateadd'  => $forms->dateadd,
            'author'  => $forms->author,
            'status'  => $forms->status
        ];


        $id = (int) $forms->id;

        if ($id === 0) {
            $this->tableGateway->insert($data);
            return $this->tableGateway->lastInsertValue;
        }

        try {
            $this->getForms($id);
        } catch (RuntimeException $e) {
            throw new RuntimeException(sprintf(
                'Cannot update form with identifier %d; does not exist',
                $id
            ));
        }

        $this->tableGateway->update($data, ['forms.id' => $id]);
    }

    public function deleteForms($id)
    {
        $this->tableGateway->delete(['id' => (int) $id]);
    }
}
?>
