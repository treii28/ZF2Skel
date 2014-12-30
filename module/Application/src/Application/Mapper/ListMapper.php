<?php
/**
 * Created by PhpStorm.
 * User: scottw
 * Date: 12/30/14
 * Time: 5:17 PM
 */

namespace Application\Mapper;

use Application\Entity\ListXref;
use Application\Entity\Lists;
use Application\Entity\Types;

class ListMapper extends AbstractMapper {

    const ENTITY_NAME = 'Application\\Entity\\ListXref';

    public function getXrefMember($listXref) {
        $list = $listXref->getList();
        $type = $list->getType();
        $entityName = $type->getEntityName();
        $fullEntityName = 'Application\\Entity\\' . $entityName;
        $memberId = $listXref->getMemberId();
        $member = $this->getEntityManager()->find($fullEntityName,$memberId);
        return $member;
    }

    public function findRecordByName($name) {
        $list = $this->getEntityManager()->getRepository('Application\\Entity\\Lists')->findOneBy(array('listName' => $name));
        $listXref = $this->getEntityManager()->find(self::ENTITY_NAME,$list->getListId());
        return $listXref;
    }
}