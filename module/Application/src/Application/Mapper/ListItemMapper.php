<?php
/**
 * Created by PhpStorm.
 * User: scottw
 * Date: 12/30/14
 * Time: 5:17 PM
 */

namespace Application\Mapper;

//use Application\Entity\Lists;
//use Doctrine\ORM\EntityRepository;
//use Application\Entity\ListItems;
//use Application\Entity\Types;

class ListItemMapper extends AbstractMapper {

    const ENTITY_NAME = 'Application\\Entity\\ListItems';

    const TYPE_NAME =  "";

    /**
     * @var ListMapper $_listMapper
     */
    private $_listMapper;

    public function __construct() {
        parent::__construct();
    }

    protected function getEntityName() {
        return self::ENTITY_NAME;
    }

    /**
     * @param \Application\Entity\ListItems $listItem
     * @return string
     */
    public function getListItemDiscriminatorValue(\Application\Entity\ListItems $listItem) {
        $meta = $this->getEntityManager()->getMetadataFactory()->getMetadataFor(get_class($listItem));
        return $meta->discriminatorValue;
    }

    public function findRecordsByListName($listName) {
        $list = $this->getListMapper()->findRecordByName($listName);
        $listItemss = $this->getRepo()->findBy(array('ListId' => $list->getListId()));
        return $listItemss;
    }

    public function findRecordsByListId($listId) {
        $listItemss = $this->getRepo()->findBy(array('ListId' => $listId));
        return $listItemss;
    }

    /**
     * @return ListMapper
     */
    public function getListMapper()
    {
        return $this->getMapper('ListMapper');
    }
}