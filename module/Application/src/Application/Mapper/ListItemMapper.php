<?php
/**
 * Created by PhpStorm.
 * User: scottw
 * Date: 12/30/14
 * Time: 5:17 PM
 */

namespace Application\Mapper;

//use Doctrine\ORM\EntityRepository;
use Application\Entity\Lists;
use Application\Entity\ListItems;
use Application\Entity\ItemOptions;
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
     * @param ListItems $listItem
     * @return string
     */
    public function getListItemDiscriminatorValue(ListItems &$listItem) {
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
     * create and set an option for a given list item
     *
     * @param ListItems $listItem
     * @param string $ioDesc
     * @param boolean $val
     * @return Lists
     * @throws \Exception
     */
    public function setOption(ListItems &$listItem, $ioDesc, $val) {
        if(!in_array($ioDesc, $listItem->getValidOptions())) {
            throw new \Exception(__METHOD__ . " invalid option '" . $ioDesc . "'");
        }
        $newOpt = new ItemOptions();
        $newOpt->setDescription($ioDesc);
        $newOpt->setContent($val);
        $this->getEntityManager()->persist($newOpt);

        $this->removeItemOptionsByDescription($listItem, $ioDesc);
        $listItem->addItemOption($newOpt);

        $this->getEntityManager()->flush();
    }

    /**
     * clear the current list of all list items
     *
     * @param ListItems $listItem
     */
    public function removeAllItemOptions(ListItems &$listItem) {
        foreach($listItem->getItemOptions()->getIterator() as $itemOption) {
            $listItem->removeItemOption($itemOption);
        }
        $this->getEntityManager()->flush();
    }

    /**
     * Remove ItemOption by description
     *
     * @param ListItems $listItem
     * @param string $ioDesc
     */
    public function removeItemOptionsByDescription(ListItems &$listItem, $ioDesc)
    {
        $listItem->getOptions($ioDesc)->forAll(
            function($k, $itemOption) use (&$listItem) {
                $listItem->removeItemOption($itemOption);
            }
        );
        $this->getEntityManager()->flush();
    }

    /**
     * @return ListMapper
     */
    public function getListMapper()
    {
        return $this->getMapper('ListMapper');
    }
}