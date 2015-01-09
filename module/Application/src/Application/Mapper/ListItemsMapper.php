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

class ListItemsMapper extends AbstractMapper {

    const ENTITY_NAME = 'Application\\Entity\\ListItems';

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
        $entityName = (class_exists('Application\\Entity\\Lists\\'.$typeName)) ? 'Application\\Entity\\Lists\\'.$typeName : 'Application\\Entity\\ListItems';
        return $entityName;
        */
        return self::ENTITY_NAME;
    }


    /**
     * @param \Application\Entity\ListItems $listRef
     * @return string
     */
    public function getListRefEntityName($listRef) {
        $refEntity = 'Application\\Entity\\' . $listRef->getList()->getType()->getEntityName();
        return $refEntity;
    }

    /**
     * @param \Application\Entity\ListItems $listRef
     * @return \Doctrine\ORM\EntityRepository
     */
    public function getListRefRepo($listRef) {
        $refRepo = $this->getEntityManager()->getRepository($this->getListRefEntityName($listRef));
        return $refRepo;
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
        if(!($this->_listMapper instanceof ListMapper)) {
            $this->_listMapper = $this->getServiceLocator()->get('ListMapper');
        }
        return $this->_listMapper;
    }
}