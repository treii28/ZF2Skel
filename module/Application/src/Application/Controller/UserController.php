<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Entity\Users;
use Application\Mapper\UserMapper;

class UserController extends AbstractController
{
    /**
     * @var \Doctrine\ORM\EntityManager $entity_manager
     */
    protected $entity_manager;
    /**
     * @var UserMapper $_Mapper
     */
    protected $_Mapper;

    public function indexAction()
    {
        $users = $this->getMapper()->findAll();

        return new ViewModel(array('users' => $users));
    }

    public function addAction()
    {
        $user = $this->getUser();
        if ($this->request->isPost()) {
            $this->getMapper()->persistInstance($user);

            return $this->redirect()->toRoute('user');
        }
        return new ViewModel(array('user' => $user));
    }

    public function editAction()
    {
        $id = (int) $this->params()->fromRoute('userId', 1);
        $user = $this->getUser($id);

        if ($this->request->isPost()) {
            $this->getMapper()->persistInstance($user);

            return $this->redirect()->toRoute('user');
        }

        return new ViewModel(array('user' => $user));
    }

    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('userId', 0);
        $user = $this->getUser($id);

        if ($this->request->isPost()) {
            $this->getMapper()->removeInstance($user);

            return $this->redirect()->toRoute('user');
        }

        return new ViewModel(array('user' => $user));
    }

    /**
     * @return UserMapper
     */
    protected function getMapper() {
        if(!$this->_Mapper) {
            $this->_Mapper = $this->getServiceLocator()->get('UserMapper');
        }
        return $this->_Mapper;
    }

    protected function getUser($id=null)
    {
        $user = ((is_null($id)) ?
            new Users()
            :
            $users = $this->getMapper()->findRecordById($id)
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
