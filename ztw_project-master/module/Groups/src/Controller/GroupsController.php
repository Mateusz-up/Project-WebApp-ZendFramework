<?php

namespace Groups\Controller;

use Groups\Form\GroupsForm;

use Groups\Model\Groups;
use Groups\Model\GroupsTable;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class GroupsController extends AbstractActionController
{
    private $table;

    public function __construct(GroupsTable $table)
    {
        $this->table = $table;
    }

    public function indexAction()
    {
        return new ViewModel([
            'groups' => $this->table->fetchAll(),
        ]);
    }

    public function addAction()
    {
		$form = new GroupsForm();
        $form->get('submit')->setValue('Add');

        $request = $this->getRequest();

        if (! $request->isPost()) {
            return ['form' => $form];
        }

        $group = new Groups();
        $form->setInputFilter($group->getInputFilter());
        $form->setData($request->getPost());

        if (! $form->isValid()) {
            return ['form' => $form];
        }

        $group->exchangeArray($form->getData());
        $this->table->savegroup($group);
        return $this->redirect()->toRoute('groups');
		
	
    }

    public function editAction()
    {
      
	  $id = (int) $this->params()->fromRoute('id', 0);

        if (0 === $id) {
            return $this->redirect()->toRoute('groups', ['action' => 'add']);
        }

     
        try {
            $group = $this->table->getgroup($id);
        } catch (\Exception $e) {
            return $this->redirect()->toRoute('groups', ['action' => 'index']);
        }

        $form = new GroupsForm();
        $form->bind($group);
        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();
        $viewData = ['id' => $id, 'form' => $form];

        if (! $request->isPost()) {
            return $viewData;
        }

        $form->setInputFilter($group->getInputFilter());
        $form->setData($request->getPost());

        if (! $form->isValid()) {
            return $viewData;
        }

        $this->table->savegroup($group);

       
        return $this->redirect()->toRoute('groups', ['action' => 'index']);
	  
	  
	  
    }

    public function deleteAction()
    {
       
	   $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('groups');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $id = (int) $request->getPost('id');
                $this->table->deletegroup($id);
            }

            // Redirect to list of albums
            return $this->redirect()->toRoute('groups');
        }

        return [
            'id'    => $id,
            'groups' => $this->table->getgroup($id),
        ];
	   
	   
	   
    }
}
