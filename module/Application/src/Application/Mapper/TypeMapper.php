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
}