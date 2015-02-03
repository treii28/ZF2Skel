<?php
/**
 * Created by PhpStorm.
 * User: scottw
 * Date: 2/3/15
 * Time: 5:14 PM
 */

namespace Application\Mapper;

use Application\Entity\Materials;
use Doctrine\Common\Collections\Criteria;

class MaterialMapper extends ListItemMapper {

    const ENTITY_NAME = 'Application\\Entity\\Materials';

    /**
     * @param string $optionName
     * @param integer $val
     * @return array
     * @throws \Exception for invalid option name
     */
    public function getMaterialsByOption($optionName, $val=1) {
        if(!in_array($optionName, Materials::getValidOptions())) {
            throw new \Exception(__METHOD__ . " invalid optionName '$optionName'");
        }

        $qb = $this->getQueryBuilder();
        $q = $qb->select('m')
            ->innerJoin('ItemOptions', 'io', 'WITH', 'io.ListItemId = :ListItemId')
            ->where('io.Description = ?', $optionName)
            ->andWhere('io.Content = ?', $val)
            ->orderBy('m.MaterialName')
            ->getDQL();
        $qem = $this->getEntityManager()->createQuery($q);
        $result = $qem->getResult($qem::HYDRATE_OBJECT);
        return $result;
    }

    /**
     * @return ListItemMapper
     */
    public function getListItemMapper()
    {
        return $this->getMapper('ListItemMapper');
    }
}