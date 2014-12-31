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

    /**
     * @param \Application\Entity\Lists\XrefAbstract $listRef
     */
    public function populateListMembers(&$listRef) {
        $list = $listRef->getList();
        $type = $list->getType();
        $listRef->initMembers(); // clear the member array
        foreach($this->getRepo()->findBy(array('listId' => $list->getListId())) as $member) {
            $refEntity = 'Application\\Entity\\' . $type->getEntityName();
            $refRepo = $this->getEntityManager()->getRepository($refEntity);
            $memObj = $refRepo->find($member->getMemberId());
            if($memObj instanceof $refEntity) {
                $listRef->addMember($memObj);
            }
        }
    }

    public function findRecordByListName($name) {
        $list = $this->getListMapper()->getListByName($name);
        $entity = $this->getListMapper()->getTypeMapper()->getTypeEntityName($list->getTypeId());
        $type = $list->getType();
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