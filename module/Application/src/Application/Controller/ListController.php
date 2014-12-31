<?php

namespace Application\Controller;

use Zend\View\Model\ViewModel;
use Application\Mapper\ListMapper;

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
        $lists = $this->getMapper()->getListsByType('MaterialCollection');

        return new ViewModel(array('lists' => $lists));
    }

    public function showAction() {
        $listName = $this->params()->fromRoute('listName', 'Acryllic Materials');
        $listRef = $this->getListByName($listName);
        $member = $this->getListMember($listRef);

        return new ViewModel(array('list' => $listRef, 'member' => $member));
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

    protected function getListByName($name=null)
    {
        $list = $this->getMapper()->findRecordByName($name);

        return $list;
    }

    protected function getListMember($listRef) {
        $member = $this->getMapper()->getXrefMember($listRef);

        return $member;
    }
}
