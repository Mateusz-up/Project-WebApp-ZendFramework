<?php
namespace Forms\Controller;

use Forms\Model\FormsTable;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Forms\Form\FormsForm;
use Forms\Model\Forms;
use Groups\Model\GroupsTable;
use Groups\Model\Groups;
use Forms\Model\FormGroupTable;
use Forms\Model\FormGroup;
class FormsController extends AbstractActionController
{
    private $table;
    private $groupTable;
    private $formGroupTable;

    public function __construct(FormsTable $table, GroupsTable $groupsTable, FormGroupTable $formGroupTable)
    {
        $this->table = $table;
        $this->groupTable = $groupsTable;
        $this->formGroupTable = $formGroupTable;

    }

    public function indexAction()
    {
       return new ViewModel([
            'forms' => $this->table->fetchAll(),
        ]);
    }

    public function addAction()
    {
        $groups = $this->groupTable->fetchAll();
        $groupsArray = [];
        foreach ($groups as $group)
        {
            $groupsArray[$group->id] =  $group->name;
        }

        $form = new FormsForm();
        $form->get('groups')->setValueOptions($groupsArray);
        $form->get('submit')->setValue('Add');

        $request = $this->getRequest();

        if (! $request->isPost()) {
            return ['form' => $form];
        }
        $forms = new Forms();
        $form->setInputFilter($forms->getInputFilter());
        $form->setData($request->getPost());

        if (! $form->isValid()) {
            return ['form' => $form];
        }

        $forms->exchangeArray($form->getData());
        $lastInsertedId = $this->table->saveForms($forms);
        $formgroupArrayToSave =['id' =>$lastInsertedId, 'groups' =>$forms->groups ];

        $this->formGroupTable->save($formgroupArrayToSave);

        return $this->redirect()->toRoute('forms');
    }

    public function editAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);

        if (0 === $id) {
            return $this->redirect()->toRoute('forms', ['action' => 'add']);
        }

        try {
            $forms = $this->table->getForms($id);
        } catch (\Exception $e) {
            return $this->redirect()->toRoute('forms', ['action' => 'index']);
        }
        $groups = $this->groupTable->fetchAll();
        $formgroup = $this->formGroupTable->getByForm($id);

        $form = new FormsForm();
        $form->bind($forms);

        $groupsArray = [];
        foreach ($groups as $group)
        {
            $groupsArray[$group->id] = $group->name;
        }

        $form->get('groups')->setValueOptions($groupsArray);

        $activeGroup =[];
        foreach ($formgroup as $row)
        {
            array_push($activeGroup,$row['groupid']);
        }
        $form->get('groups')->setValue($activeGroup);


        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();
        $viewData = ['id' => $id, 'form' => $form];

        if (! $request->isPost()) {
            return $viewData;
        }

        $form->setInputFilter($forms->getInputFilter());
        $form->setData($request->getPost());

        if (! $form->isValid()) {
            return $viewData;
        }

        $this->table->saveForms($forms);

        $formgroupArrayToSave =['id' =>$id, 'groups' =>$forms->groups ];
        $this->formGroupTable->save($formgroupArrayToSave);
        return $this->redirect()->toRoute('forms', ['action' => 'index']);

    }

    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('forms');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $id = (int) $request->getPost('id');
                $this->table->deleteForms($id);
            }

            return $this->redirect()->toRoute('forms');
        }

        return [
            'id'    => $id,
            'forms' => $this->table->getForms($id),
        ];

    }
}
?>
