<?php
namespace Users\Controller;

use Users\Model\UsersTable;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Users\Form\UsersForm;
use Users\Model\Users;

class UsersController extends AbstractActionController
{
    private $table;

    public function __construct(UsersTable $table)
    {
        $this->table = $table;
    }

    public function indexAction()
    {
        return new ViewModel([
            'users' => $this->table->fetchAll(),
        ]);
    }

    public function addAction()
    {
        $form = new UsersForm();
        $form->get('submit')->setValue('Add');

        $request = $this->getRequest();

        if (! $request->isPost()) {
            return ['form' => $form];
        }

        $users = new Users();
        $form->setInputFilter($users->getInputFilter());
        $form->setData($request->getPost());

        if (! $form->isValid()) {
            return ['form' => $form];
        }

        $users->exchangeArray($form->getData());
        $this->table->saveUsers($users);
        return $this->redirect()->toRoute('users');
    }


    public function editAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);

        if (0 === $id) {
            return $this->redirect()->toRoute('users', ['action' => 'add']);
        }

        // Retrieve the users with the specified id. Doing so raises
        // an exception if the users is not found, which should result
        // in redirecting to the landing page.
        try {
            $users = $this->table->getUsers($id);
        } catch (\Exception $e) {
            return $this->redirect()->toRoute('users', ['action' => 'index']);
        }

        $form = new UsersForm();
        $form->bind($users);
        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();
        $viewData = ['id' => $id, 'form' => $form];

        if (! $request->isPost()) {
            return $viewData;
        }

        $form->setInputFilter($users->getInputFilter());
        $form->setData($request->getPost());

        if (! $form->isValid()) {
            return $viewData;
        }

        $this->table->saveUsers($users);

        // Redirect to users list
        return $this->redirect()->toRoute('users', ['action' => 'index']);
    }

    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('users');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $id = (int) $request->getPost('id');
                $this->table->deleteUsers($id);
            }

            // Redirect to list of users
            return $this->redirect()->toRoute('users');
        }

        return [
            'id'    => $id,
            'users' => $this->table->getUsers($id),
        ];
    }
}
?>