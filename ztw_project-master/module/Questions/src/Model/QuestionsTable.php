<?php
namespace Questions\Model;

use RuntimeException;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\TableGatewayInterface;

class QuestionsTable
{
    private $tableGateway;

    public function __construct(TableGatewayInterface $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll()
    {
        return $this->tableGateway->select();
    }

    public function getQuestion($id)
    {
        $id = (int) $id;
        $rowset = $this->tableGateway->select(['id' => $id]);
        $row = $rowset->current();
        if (! $row) {
            throw new RuntimeException(sprintf(
                'Could not find row with identifier %d',
                $id
            ));
        }

        return $row;
    }

    public function saveQuestion(Questions $question)
    {
        $data = [
            'name' => $question->name,
            'type'  => $question->type,
        ];

        $id = (int) $question->id;

        if ($id === 0) {
            $this->tableGateway->insert($data);
            return;
        }

        try {
            $this->getQuestion($id);
        } catch (RuntimeException $e) {
            throw new RuntimeException(sprintf(
                'Cannot update question with identifier %d; does not exist',
                $id
            ));
        }

        $this->tableGateway->update($data, ['id' => $id]);
    }

    public function deleteQuestion($id)
    {
        $this->tableGateway->delete(['id' => (int) $id]);
    }
}
?>
