<?php

namespace Questions\Controller;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use Questions\Form\QuestionsForm;
use Questions\Model\QuestionsTable;
use Questions\ModelQuestions;
use Questions\Model\Questions;




class QuestionsController extends AbstractActionController
{
    private $table;

    public function __construct(QuestionsTable $table)
    {
        $this->table = $table;
    }

    public function indexAction()
    {
        return new ViewModel([
            'questions' => $this->table->fetchAll(),
        ]);
    }

    public function addAction()
    {
        $form = new QuestionsForm();
        $form->get('submit')->setValue('Add');

        $request = $this->getRequest();

        if (! $request->isPost()) {
            return ['form' => $form];
        }
/////////////////////////////////////////
        $question = new Questions();
        $form->setInputFilter($question->getInputFilter());
        $form->setData($request->getPost());

        if (! $form->isValid()) {
            return ['form' => $form];
        }

        $question->exchangeArray($form->getData());
        $this->table->saveQuestion($question);
        return $this->redirect()->toRoute('questions');
    }

    public function editAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);

        if (0 === $id) {
            return $this->redirect()->toRoute('questions', ['action' => 'add']);
        }

        try {
            $question = $this->table->getQuestion($id);
        } catch (\Exception $e) {
            return $this->redirect()->toRoute('questions', ['action' => 'index']);
        }

        $form = new QuestionsForm();
        $form->bind($question);
        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();
        $viewData = ['id' => $id, 'form' => $form];

        if (! $request->isPost()) {
            return $viewData;
        }

        $form->setInputFilter($question->getInputFilter());
        $form->setData($request->getPost());

        if (! $form->isValid()) {
            return $viewData;
        }

        $this->table->saveQuestion($question);

        // Redirect to questions list
        return $this->redirect()->toRoute('questions', ['action' => 'index']);
    }

    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('questions');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $id = (int) $request->getPost('id');
                $this->table->deleteQuestion($id);
            }

        
            return $this->redirect()->toRoute('questions');
        }

        return [
            'id'    => $id,
            'question' => $this->table->getQuestion($id),
        ];
    }
}
