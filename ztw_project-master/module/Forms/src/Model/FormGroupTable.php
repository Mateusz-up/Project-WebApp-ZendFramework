<?php
namespace Forms\Model;

use RuntimeException;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\TableGatewayInterface;

class FormGroupTable
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

    public function getByForm($id)
    {
        $id = (int) $id;
        $rowset = $this->tableGateway->select(['formid' => $id]);

        if (! $rowset) {
            throw new RuntimeException(sprintf(
                'Could not find row with identifier %d',
                $id
            ));
        }

        return $rowset->toArray();
    }

    public function save(array $formgroup)
    {
        $id = (int) $formgroup['id'];
        $this->deleteByFormId($id);
        foreach ($formgroup['groups'] as $key => $value) {
            $this->tableGateway->insert(array('formid' =>$id, 'groupid' => $value ));
        }

        return;
    }

    public function deleteByFormId($id)
    {
        $this->tableGateway->delete(['formid' => (int) $id]);
    }
}
?>
