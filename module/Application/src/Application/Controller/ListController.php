<?php

namespace Application\Controller;

use Zend\View\Model\ViewModel;
use Application\Mapper\ListMapper;
use Application\Mapper\TypeMapper;

class ListController extends AbstractController
{
    /**
     * @var \Doctrine\ORM\EntityManager $entity_manager
     */
    protected $entity_manager;

    public function indexAction()
    {
        $em = $this->getEntityManager();
        $lm = $this->getMapper();
        $tm = $this->getTypeMapper();
        return new ViewModel();
    }

    public function typesAction() {
        $types = $this->getTypeMapper()->findAll('\\Application\\Entity\\Types');
        return new ViewModel(array('types' => $types));
    }

    public function showtypeAction() {
        $typeId = $this->params()->fromRoute('id', '');
        $type = $this->getTypeMapper()->findRecordById($typeId);

        $lists = $this->getMapper()->getListsByType($type->getTypeName());
        return new ViewModel(array('type' => $type, 'lists' => $lists));
    }

    public function showlistAction() {
        $listId = $this->params()->fromRoute('id', '');
        $listRef = $this->getMapper()->findRecordById($listId);
        $this->getMapper()->populateListMembers($listRef);

        return new ViewModel(array('listRef' => $listRef, 'members' => $listRef->getMembers()));
    }

    /**
     * @return TypeMapper
     */
    protected function getTypeMapper() {
        return $this->getMapper('Type');
    }

    /**
     * @param integer|string $listId
     * @return \Doctrine\Common\Collections\ArrayCollection
     * @throws \Exception
     */
    protected function getListMembers($listId) {
        $listRef = $this->getMapper()->findRecordById($listId);
        $this->getMapper()->populateListMembers($listRef);
        $members = $listRef->getMembers();

        return $listRef->getMembers();
    }
}
