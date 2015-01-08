<?php

namespace Application\Controller;

use Zend\View\Model\ViewModel;
use Application\Mapper\ListMapper;
use Application\Mapper\TypeMapper;
use Application\Mapper\ListXrefMapper;

class ListController extends AbstractController
{
    /**
     * @var \Doctrine\ORM\EntityManager $_objectManager
     */
    protected $_objectManager;
    /**
     * @var ListMapper $_Mapper
     */
    protected $_Mapper;

    public function indexAction()
    {
        $em = $this->getMapper()->getEntityManager();
        //$Type = $this->getTypeMapper()->findRecordById(1);
        $List = $this->getMapper()->findRecordById(1);
        /*
        $Type = new \Application\Entity\Types();
        $Type->setTypeName('MaterialCollection');
        $em->persist($Type);
        $em->flush();
        $List = new \Application\Entity\Lists();
        $List->setType($Type);
        $List->setListName('My Materials');
        $em->persist($List);
        $em->flush();
        */

        //$ListItem = new \Application\Entity\ListItems();
        $MaterialItem = new \Application\Entity\Materials();
        $MaterialItem->setList($List);
        $MaterialItem->setMemberId(1);
        $MaterialItem->setMaterialName('Cotton');
        $em->persist($MaterialItem);
        $em->flush();
        return new ViewModel();
    }

    public function typesAction() {
        $types = $this->getTypeMapper()->findAll();
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
     * @param null|string $mapperName
     * @return ListMapper|\Application\Mapper\AbstractMapper
     * @throws \Exception on mapper class not found
     */
    protected function getMapper($mapperName=null) {
        if(empty($mapperName)) {
            if(!$this->_Mapper) {
                $this->_Mapper = $this->getServiceLocator()->get('ListMapper');
            }
            return $this->_Mapper;
        } elseif(class_exists('Application\\Mapper\\'.$mapperName)) {
            return $this->getServiceLocator()->get($mapperName);
        } else {
            throw new \Exception(__METHOD__." mapper not found for '$mapperName'");
        }
    }

    /**
     * @return TypeMapper
     */
    protected function getTypeMapper() {
        return $this->getServiceLocator()->get('TypeMapper');
    }
    /**
     * @param integer|string $id
     * @return ListXrefMapper
     * @throws \Exception on Xref mapper not find
     */
    protected function getXrefMapper($id) {
        $typeMapper = $this->getMapper()->getListTypeName($id) . 'Mapper';
        if(class_exists('\\Application\\Mapper\\Lists\\' . $typeMapper)) {
            return $this->getServiceLocator()->get($typeMapper);
        } else {
            throw new \Exception(__METHOD__." type Xref mapper not found");
        }
    }

    /**
     * @param integer|string $id
     * @return \Doctrine\Common\Collections\Collection
     * @throws \Exception
     */
    protected function getListMembers($listId) {
        $listRef = $this->getMapper()->findRecordById($listId);
        $this->getMapper()->populateListMembers($listRef);
        $members = $listRef->getMembers();

        return $listRef->getMembers();
    }
}
