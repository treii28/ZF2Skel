<?php
/**
 * Created by PhpStorm.
 * User: scottw
 * Date: 12/30/14
 * Time: 5:17 PM
 */

namespace Application\Mapper;

use Application\Entity\Lists;
use Doctrine\ORM\EntityRepository;
//use Application\Entity\ListXref;
//use Application\Entity\Types;

class ListXrefMapper extends AbstractMapper {

    const ENTITY_NAME = 'Application\\Entity\\ListXref';

    const TYPE_NAME =  "";

    /**
     * @var ListMapper $_listMapper
     */
    private $_listMapper;

    public function __construct() {
        parent::__construct();
    }

    protected function _getEntityName() {
        /*
        $cclass = get_called_class();
        $typeName = $cclass::TYPE_NAME;
        $entityName = (class_exists('Application\\Entity\\Lists\\'.$typeName)) ? 'Application\\Entity\\Lists\\'.$typeName : 'Application\\Entity\\ListXref';
        return $entityName;
        */
        return 'Application\\Entity\\ListXref';
    }

    /**
     * @param \Application\Entity\Lists\XrefAbstract $listRef
     */
    public function populateListMembers(&$listRef) {
        $listRef->initMembers(); // clear the member array
        foreach($this->getRepo()->findBy(array('ListId' => $listRef->getList()->getListId())) as $member) {
            $refEntity = 'Application\\Entity\\' . $listRef->getList()->getType()->getEntityName();
            $refRepo = $this->getEntityManager()->getRepository($refEntity);
            $memObj = $refRepo->find($member->getMemberId());
            if($memObj instanceof $refEntity) {
                $listRef->addMember($memObj);
            }
        }
    }

    /**
     * @param \Application\Entity\Lists\XrefAbstract $listRef
     * @return string
     */
    public function getListRefEntityName($listRef) {
        $refEntity = 'Application\\Entity\\' . $listRef->getList()->getType()->getEntityName();
        return $refEntity;
    }

    /**
     * @param \Application\Entity\Lists\XrefAbstract $listRef
     * @return \Doctrine\ORM\EntityRepository
     */
    public function getListRefRepo($listRef) {
        $refRepo = $this->getEntityManager()->getRepository($this->getListRefEntityName($listRef));
        return $refRepo;
    }

    public function findRecordByListName($name) {
        $list = $this->getListMapper()->getListByName($name);
        $listXref = $this->getEntityManager()->find(self::ENTITY_NAME,$list->getListId());
        return $listXref;
    }

    /**
     * @return ListMapper
     */
    public function getListMapper()
    {
        if(!($this->_listMapper instanceof ListMapper)) {
            $this->_listMapper = $this->getServiceLocator()->get('ListMapper');
        }
        return $this->_listMapper;
    }
}