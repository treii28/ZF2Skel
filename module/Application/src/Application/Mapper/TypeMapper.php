<?php
/**
 * Created by PhpStorm.
 * User: scottw
 * Date: 12/31/14
 * Time: 2:01 PM
 */

namespace Application\Mapper;

use Application\Entity\Types;
use Doctrine\ORM\EntityRepository;

class TypeMapper extends AbstractMapper {

    const ENTITY_NAME = 'Application\\Entity\\Types';

    /**
     * @param string $name
     * @return null|Types
     */
    public function findRecordByName($name) {
        return $this->getRepo()->findOneBy(array('TypeName' => $name));
    }

    /**
     * @param integer|string $id
     * @return string
     * @throws \Exception on type not found
     */
    public function getTypeEntityName($id) {
        $type = (intval($id > 0)) ? $this->findRecordById($id) : $this->findRecordByName($id);
        if(!($type instanceof Types)) {
            throw new \Exception(__METHOD__ . " Types record not found for '$id'");
        }
        return 'Application\\Entity\\' . $type->getEntityName();
    }
}