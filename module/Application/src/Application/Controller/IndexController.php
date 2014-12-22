<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Entity\Users;

class IndexController extends AbstractActionController
{
    protected $_objectManager;

    public function indexAction()
    {
        $users = $this->getObjectManager()->getRepository('\Application\Entity\Users')->findAll();

        return new ViewModel(array('users' => $users));
    }

    public function addAction()
    {
        if ($this->request->isPost()) {
            $user = $this->getUser();

            $this->getObjectManager()->persist($user);
            $this->getObjectManager()->flush();
            $newId = $user->getUserId();

            return $this->redirect()->toRoute('home');
        }
        return new ViewModel();
    }

    public function editAction()
    {
        $id = (int) $this->params()->fromRoute('userId', 1);
        $user = $this->getObjectManager()->find('\Application\Entity\Users', $id);

        if ($this->request->isPost()) {
            $user = $this->populateUserFromPost($user);

            $this->getObjectManager()->persist($user);
            $this->getObjectManager()->flush();

            return $this->redirect()->toRoute('home');
        }

        return new ViewModel(array('user' => $user));
    }

    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        $user = $this->getUser($id);

        if ($this->request->isPost()) {
            $this->getObjectManager()->remove($user);
            $this->getObjectManager()->flush();

            return $this->redirect()->toRoute('home');
        }

        return new ViewModel(array('user' => $user));
    }

    protected function getObjectManager()
    {
        if (!$this->_objectManager) {
            $this->_objectManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        }

        return $this->_objectManager;
    }

    protected function getUser($id=null)
    {
        $user = ((is_null($id)) ?
            new Users()
            :
            $this->getObjectManager()->find('\Application\Entity\Users', $id)
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
