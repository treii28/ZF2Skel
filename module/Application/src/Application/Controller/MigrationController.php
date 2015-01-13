<?php

namespace Application\Controller;

use Application\Controller\AbstractController;
use Zend\Mvc\Application;
use Zend\View\Model\ViewModel;
use Zend\Db\Adapter\Adapter as ZDbAdapter;
//use Zend\Db\Sql\Sql;
use Zend\Db\TableGateway\TableGateway;

class MigrationController extends AbstractController
{
    /**
     * @var \Zend\Db\Adapter\Adapter $_joomla
     */
    private $_joomla;

    /**
     * @var array $_joomlaTables
     */
    private $_joomlaTables = array();

    public function indexAction()
    {

        $myActions = $this->getActionNames(array('indexAction'));
        return new ViewModel(array('actions' => $myActions));
    }

    public function materialsAction() {
        $materialTable = $this->getJoomlaTable('sx_color');
        $allMats = $this->getNamedList('All Materials', 'Materials');

        foreach($materialTable->select() as $material) {
            $newMat = $this->getMaterialsItem($material->color_desc,$material->color_id);
            $allMats->addListitem($newMat);
        }

        $this->getEntityManager()->persist($allMats);
        $this->getEntityManager()->flush();


        // build material collections
        $materialCollectionTable = $this->getJoomlaTable('sx_material');

        //$matCollType = $this->getNamedType('Material Collection');
        $matCollList = $this->getNamedList('All Material Collections', 'Material Collection List');
        foreach($materialCollectionTable->select() as $collection) {
            $matColl = $this->getNamedList($collection->material_desc, 'Material Collection');
            // add materials to collection
            $rowset = $materialTable->select(array('material_id' => $collection->material_id));
            foreach($rowset as $row) {
                $newMat = $this->getMaterialsItem($row->color_desc,$row->color_id);
                $matColl->addListitem($newMat);
            }
            $this->getEntityManager()->persist($matColl);
            $this->getEntityManager()->flush();

            $subList = $this->getSublist($matColl->getListId(),$matCollList);
            $matCollList->addListitem($subList);
        }

        // do all default materials (not in a collection)
        $defCollName = 'not in a collection';
        $defColl = $this->getNamedList($defCollName, 'Material Collection');
        $where = new \Zend\Db\Sql\Where();
        $where->greaterThanOrEqualTo('material_id', 99);
        $rowset = $materialTable->select($where);
        foreach($rowset as $row) {
            $defMat = $this->getMaterialsItem($row->color_desc,$row->color_id);
            $defColl->addListitem($defMat);
        }
        $this->getEntityManager()->persist($defColl);
        $this->getEntityManager()->flush();

        $defCollId = $defColl->getListId();

        $subList = $this->getSublist($defColl->getListId(),$matCollList);
        $matCollList->addListitem($subList);

        $this->getEntityManager()->persist($matCollList);
        $this->getEntityManager()->flush();

        // run through again to create collection lists

        foreach($materialTable->select() as $material) {
            //clean up unlinked materials (anything with a material_id value 99 or over) to all point to the default 'not in collection' mat created above
            // get the material collection based on the old link record
            if($material->material_id < 99) {
                $rowset = $materialCollectionTable->select(array('material_id' => $material->material_id));
                $row = $rowset->current();
                $matColl = $this->getNamedList($row->material_desc, 'Material Collection');
            } else {
                $matColl = $this->getNamedList($defCollName, 'Material Collection');
            }
            $matItem = $this->findLegacyMaterial($material->color_id);
            $newLink = $this->getSubItem($matItem->getListItemId(),$matColl);

            $matColl->addListitem($newLink);
            $this->getEntityManager()->persist($allMats);
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @param integer $legacyId
     * @return \Application\Entity\Materials
     */
    private function findLegacyMaterial($legacyId) {
        return $this->getServiceLocator()->get('ListMapper')->getRepo('\\Application\\Entity\\Materials')->findOneBy(array('MaterialId' => $legacyId));
    }

    /**
     * @param string $name
     * @param null|integer $legacyId
     * @return \Application\Entity\Materials
     */
    private function getMaterialsItem($name,$legacyId=null) {
        $mat = $this->getEntityManager()->getRepository('\\Application\\Entity\\Materials')->findOneBy(array('MaterialName' => $name, 'MaterialId' => $legacyId));
        if(!($mat instanceof \Application\Entity\Materials)) {
            $mat = new \Application\Entity\Materials();
            $mat->setMaterialName($name);
            $mat->setMaterialId($legacyId);
            $mat->setList($this->getNamedList('All Materials', 'Materials'));
            $this->getEntityManager()->persist($mat);
            $this->getEntityManager()->flush();
        }
        return $mat;
    }

    private function getSubItem($refId,$refList) {
        $item = $this->getEntityManager()->getRepository('\\Application\\Entity\\Subitems')->findOneBy(array('RefitemId' => $refId));
        if(!$item instanceof \Application\Entity\Subitems) {
            $item = new \Application\Entity\Subitems();
            $item->setRefitemId($refId);
            $item->setList($refList);
            $this->getEntityManager()->persist($item);
            $this->getEntityManager()->flush();
        }
        return $item;
    }

    private function getSublist($refId,$listRef) {
        $sublist = $this->getEntityManager()->getRepository('\\Application\\Entity\\Sublists')->findOneBy(array('ReflistId' => $refId));
        if(!$sublist instanceof \Application\Entity\Sublists) {
            $sublist = new \Application\Entity\Sublists();
            $sublist->setReflistId($refId);
            $sublist->setList($listRef);

            $this->getEntityManager()->persist($sublist);
            $this->getEntityManager()->flush();
        }
        return $sublist;
    }
    /**
     * @return \Application\Entity\Types
     */
    private function getNamedType($typeName) {
        $type = $this->getServiceLocator()->get('TypeMapper')->findRecordByName($typeName);
        if(!($type instanceof \Application\Entity\Types)) {
            // create a new type for Materials
            $type = new \Application\Entity\Types();
            $type->setTypeName($typeName);
            $this->getEntityManager()->persist($type);
            $this->getEntityManager()->flush();
        }
        return $type;
    }

    /**
     * @param string $listName
     * @param string $typeName
     * @return \Application\Entity\Lists
     */
    private function getNamedList($listName,$typeName) {
        $list = $this->getServiceLocator()->get('ListMapper')->findRecordByName($listName);
        if(!($list instanceof \Application\Entity\Lists)) {
            // create a new type for Materials
            $list = new \Application\Entity\Lists();
            $list->setListName($listName);
            $list->setType($this->getNamedType($typeName));
            $this->getEntityManager()->persist($list);
            $this->getEntityManager()->flush();
        }
        return $list;
    }

    /**
     * @param string $tableName
     * @return TableGateway
     */
    public function getJoomlaTable($tableName) {
        if(!(in_array($tableName, $this->_joomlaTables) && ($this->_joomlaTables[$tableName] instanceof TableGateway))) {
            $this->_joomlaTables[$tableName] = new TableGateway($tableName, $this->getJoomlaAdapter());
        }
        return $this->_joomlaTables[$tableName];
    }

    /**
     * @return \Zend\Db\Adapter\Adapter
     */
    public function getJoomlaAdapter() {
        if(!($this->_joomla instanceof ZDbAdapter)) {
            $this->_joomla =  $this->getServiceLocator()->get('joomla');
        }
        return $this->_joomla;
    }
}
