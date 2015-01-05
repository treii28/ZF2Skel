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
    /**
     * @var TypeMapper $_TypeMapper
     */
    protected $_TypeMapper;
    /**
     * @var ListXrefMapper $_XrefMapper
     */
    protected $_XrefMapper;

    public function indexAction()
    {

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
        $listName = $this->params()->fromRoute('id', '');
        $listXRefMapper = $this->getXrefMapper($listName);
        $listRef = $listXRefMapper->findRecordById($listName);
        $listXRefMapper->populateListMembers($listRef);
        $members = $listRef->getMembers();

        return new ViewModel(array('listRef' => $listRef, 'members' => $members));
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
        if(!$this->_TypeMapper) {
            $this->_TypeMapper = $this->getServiceLocator()->get('TypeMapper');
        }
        return $this->_TypeMapper;
    }
    /**
     * @param integer|string $id
     * @return ListXrefMapper
     * @throws \Exception on Xref mapper not find
     */
    protected function getXrefMapper($id) {
        if(!$this->_XrefMapper) {
            $typeMapper = $this->getMapper()->getListTypeName($id) . 'Mapper';
            if(class_exists('\\Application\\Mapper\\Lists\\' . $typeMapper)) {
                $this->_XrefMapper = $this->getServiceLocator()->get($typeMapper);
            } else {
                throw new \Exception(__METHOD__." type Xref mapper not found");
            }
        }
        return $this->_XrefMapper;
    }

    /**
     * @param integer|string $id
     * @return \Doctrine\Common\Collections\Collection
     * @throws \Exception
     */
    protected function getListMembers($id) {
        $listRef = $this->getListById($id);
        $listXRefMapper = $this->getXrefMapper($id);
        $listXRefMapper->populateListMembers($listRef);
        $members = $listRef->getMembers();

        return $members;
    }
}
