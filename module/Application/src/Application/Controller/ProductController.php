<?php

namespace Application\Controller;

use Application\Controller\AbstractController;
use Zend\View\Model\ViewModel;
use Application\Entity\Product;
use Application\Mapper\ProductMapper;

class ProductController extends AbstractController
{
    public function indexAction()
    {
        $users = $this->getMapper()->findAll();

        return new ViewModel(array('users' => $users));
    }

    public function addAction()
    {
        $user = $this->getUser();
        if ($this->request->isPost()) {
            $this->getUserMapper()->persistUser($user);

            return $this->redirect()->toRoute('user');
        }
        return new ViewModel(array('user' => $user));
    }

    public function editAction()
    {
        $id = (int) $this->params()->fromRoute('userId', 1);
        $user = $this->getUser($id);

        if ($this->request->isPost()) {
            $this->getUserMapper()->persistUser($user);

            return $this->redirect()->toRoute('user');
        }

        return new ViewModel(array('user' => $user));
    }

    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('userId', 0);
        $user = $this->getUser($id);

        if ($this->request->isPost()) {
            $this->getUserMapper()->removeUser($user);

            return $this->redirect()->toRoute('user');
        }

        return new ViewModel(array('user' => $user));
    }


    protected function getUser($id=null)
    {
        $user = ((is_null($id)) ?
            new Users()
            :
            $users = $this->getUserMapper()->findUserById($id)
        );

        if ($this->request->isPost()) {
            $user->setEmail($this->getRequest()->getPost('email'));
            $user->setFirstName($this->getRequest()->getPost('firstName'));
            $user->setMiddleName($this->getRequest()->getPost('middleName'));
            $user->setLastName($this->getRequest()->getPost('lastName'));
            $user->setPhone($this->getRequest()->getPost('phone'));
        }

        return $user;
    }
}
