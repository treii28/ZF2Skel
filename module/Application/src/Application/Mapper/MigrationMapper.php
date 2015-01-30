<?php
/**
 * Created by PhpStorm.
 * User: scottw
 * Date: 12/12/14
 * Time: 4:22 PM
 */

namespace Application\Mapper;

use Application\ServiceAbstract;
use Zend\Db\Adapter\Adapter as ZDbAdapter;
//use Zend\Db\Sql\Sql;
use Zend\Db\TableGateway\TableGateway;

class MigrationMapper extends ServiceAbstract {

    /**
     * @var string $defOutFile
     */
    protected $defOutFile = "/tmp/migration.out";

    /**
     * @var string $_outType
     */
    private $_outType = 'buffer';

    /**
     * @var string $_output
     */
    private $_output;

    /**
     * @var \Zend\Db\Adapter\Adapter $_joomla
     */
    private $_joomla;

    /**
     * @var array $_joomlaTables
     */
    private $_joomlaTables = array();

    /**
     * @param null|int|\Zend\Db\Sql\Where $opt
     * @return \Zend\Db\ResultSet\ResultSet
     */
    public function getJoomlaColors($opt=null) {
        $colorTable = $this->getJoomlaTable('sx_color');
        $srch = null;
        if(is_int($opt) && (intval($opt) > 0)) {
            $srch = array('material_id' => $opt);
        } elseif($opt instanceof \Zend\Db\Sql\Where) {
            $srch = $opt;
        }
        $select = $colorTable->getSql()->select($srch)
            ->join('sx_material', 'sx_color.material_id=sx_material.material_id');
        if(!is_null($srch)) {
            $select->where($srch);
        }

        return $colorTable->selectWith($select);
        //return $colorTable->select($srch);
    }

    /**
     * @param null|int $matId
     * @return \Zend\Db\ResultSet\ResultSet
     */
    public function getJoomlaMaterials($matId=null) {
        $materialTable = $this->getJoomlaTable('sx_material');
        if(intval($matId) > 0) {
            return $materialTable->select(array('material_id' => $matId));
        } else {
            return $materialTable->select();
        }
    }

    // convert old Joomla colors to Material lists
    public function migrateJoomlaColors($fb=false) {
        if($fb>1) $this->writeOut("Starting migration of joomla colors to Materials..." . PHP_EOL . PHP_EOL);

        if($fb>1) $this->writeOut("Creating/retrieving All Materials list..." . PHP_EOL);
        $allMats = $this->getNamedList('All Materials', 'Materials');
        if($fb>1) $this->writeOut("getting joomla color list..." . PHP_EOL);
        $jCols = $this->getJoomlaColors();
        if($fb>1) $this->writeOut("Total Materials to process: " . $jCols->count() . PHP_EOL);

        $ccc = 0;
        foreach($jCols as $material) {
            if($fb>1) $this->writeOut("    [" . $ccc++ . "] adding color_id " . $material->color_id . " " . $material->color_desc . PHP_EOL);
            //$extra = $this->getMaterialData($material);

            $newMat = $this->getMaterialsItem($material->color_desc,$material->color_id);
            $extra = array(
                'SupplierName'      => "supplier_color_desc",
                'PopUpMessage'      => "popup_msg",
                'Priority'          => "priority",
                'Comment'           => "color_comment"
            );
            foreach($extra as $_k => $_v) {
                if(!empty($material->$_v) || ($material->$_v == "0")) {
                    $accMeth = 'set' . ucfirst($_k);
                    if(method_exists($newMat, $accMeth)) {
                        $newMat->$accMeth($material->$_v);
                    } else {
                        throw new \Exception(__METHOD__ . " accessor not found for property '$_k'");
                    }
                }
            }
            $this->getEntityManager()->persist($newMat);
            $this->getEntityManager()->flush();

            $allMats->addListitem($newMat);
        }

        if($fb>1) $this->writeOut("Persisting and flushing all collections list (of lists)" . PHP_EOL);
        $this->getEntityManager()->persist($allMats);
        $this->getEntityManager()->flush();

        return $this->_output;
    }

    public function migrateMaterialOptions($fb=false) {
        if($fb>1) $this->writeOut("getting joomla color list..." . PHP_EOL);
        $jCols = $this->getJoomlaColors();
        if($fb>1) $this->writeOut("Total Materials to process: " . $jCols->count() . PHP_EOL);


        $ccc = 0;
        foreach($jCols as $material) {
            if($fb>1) $this->writeOut("    [" . $ccc++ . "] reviewing material " . $material->color_id . " " . $material->color_desc . PHP_EOL);
            $extra = array(
                'Indent Capable'     => "can_indent",
                'CutOut Capable'     => "can_cutout",
                'Imprint Capable'    => "can_imprint",
                'Etch Capable'       => "can_etch",
                'CoverImage Capable' => "cover_image",
                'Leather'            => "is_leather",
                'Discontinued'       => "is_discontinued"
            );
            $matEnt = $this->getMaterialsItem($material->color_desc,$material->color_id);
            foreach($extra as $_k => $_v) {
                if($material->$_v == true){
                    $listName = $_k . " Materials";
                    if($fb>1) $this->writeOut("        adding " . $material->color_id . " " . $material->color_desc . " to " . $listName . " list" . PHP_EOL);

                    if($fb>2) $this->writeOut("        ... creating" . $listName . " option" . PHP_EOL);
                    $newOption = new \Application\Entity\ItemOptions();
                    $newOption->setItemrefId($matEnt->getId());
                    $newOption->setDescription($_v);
                    $newOption->setContent($material->$_v);
                    $this->getEntityManager()->persist($newOption);
                    $this->getEntityManager()->flush();
                }
            }
        }
    }

    // convert old Joomla materials to Material Collection Lists
    public function migrateJoomlaMaterials($fb=false) {

        if($fb>1) $this->writeOut("Starting migration of joomla materials to Material Collection Lists..." . PHP_EOL . PHP_EOL);
        $jMats = $this->getJoomlaMaterials();
        if($fb>1) $this->writeOut("Total Material Collections to process: " . $jMats->count() . PHP_EOL);

        // build material collections
        $matCollList = $this->getNamedList('All Material Collections', 'Material Collection List');
        $jMatCols = array();
        if($fb>1) $this->writeOut("Iterating through joomla materials to add specific collections..." . PHP_EOL);
        $ccount = 0;
        foreach($jMats as $collection) {
            $collId = $collection->material_id;
            if($fb>1) $this->writeOut($ccount++ . ") processing joomla material_id " . $collId . " " . $collection->material_desc . PHP_EOL);

            $matColl = $this->getNamedList($collection->material_desc, 'Material Collection');
            // add materials to collection
            $jMatCols[$collId] = $this->getJoomlaColors($collId);
            if($fb>1) $this->writeOut("Found " . $jMatCols[$collId]->count() . " matching items to add to collection" . PHP_EOL);
            $ccc = 0;
            foreach($jMatCols[$collId] as $col) {
                if($fb>1) $this->writeOut("    [" . $ccc++ . "] adding color_id " . $col->color_id . " " . $col->color_desc . PHP_EOL);
                $newMat = $this->getMaterialsItem($col->color_desc,$col->color_id);
                $matColl->addListitem($newMat);
            }
            if($fb>1) $this->writeOut("Persisting and flushing collection " . $collection->material_desc . PHP_EOL);
            $this->getEntityManager()->persist($matColl);
            $this->getEntityManager()->flush();

            if($fb>1) $this->writeOut("Adding sublist to all collections list (of lists)" . PHP_EOL);
            $subList = $this->getSublist($matColl->getListId(),$matCollList);
            $matCollList->addListitem($subList);
        }

        // do all default materials (not in a collection)
        if($fb>1) $this->writeOut("creating a list for materials not currently in a collection..." . PHP_EOL);
        $defCollName = 'not in a collection';
        $defColl = $this->getNamedList($defCollName, 'Material Collection');
        $where = new \Zend\Db\Sql\Where();
        $where->greaterThanOrEqualTo('material_id', 99);
        $noList = $this->getJoomlaColors($where);
        if($fb>1) $this->writeOut("Found " . $noList->count() . " items not in collections" . PHP_EOL);
        $ncc = 0;
        foreach($noList as $col) {
            if($fb>1) $this->writeOut("    [" . $ncc++ . "] adding color_id " . $col->color_id . " " . $col->color_desc . PHP_EOL);
            $defMat = $this->getMaterialsItem($col->color_desc,$col->color_id);
            $defColl->addListitem($defMat);
        }
        if($fb>1) $this->writeOut("Persisting and flushing default (no collection) list" . PHP_EOL);
        $this->getEntityManager()->persist($defColl);
        $this->getEntityManager()->flush();

        if($fb>1) $this->writeOut("Adding sublist to all collections list (of lists)" . PHP_EOL);
        $subList = $this->getSublist($defColl->getListId(),$matCollList);
        $matCollList->addListitem($subList);

        if($fb>1) $this->writeOut("Persisting and flushing all collections list (of lists)" . PHP_EOL);
        $this->getEntityManager()->persist($matCollList);
        $this->getEntityManager()->flush();

        return $this->_output;
    }

    public function migrateColorRefs($fb=false)
    {
        // run through again to create collection lists
        $jCols = $this->getJoomlaColors();
        if ($fb > 1) $this->writeOut("Running through all " . $jCols->count() . " joomla colors create list refs" . PHP_EOL);

        $defCollName = 'not in a collection';

        $ccc = 0;
        foreach ($jCols as $color) {
            //clean up unlinked materials (anything with a material_id value 99 or over) to all point to the default 'not in collection' mat created above
            if ($fb > 1) $this->writeOut($ccc++ . ") processing joomla color_id " . $color->color_id . " " . $color->color_desc . PHP_EOL);
            // get the material collection based on the old link record
            if ($color->material_id < 99) {
                $mat = $this->getJoomlaMaterials($color->material_id)->current();
                if ($fb > 1) $this->writeOut("Adding " . $color->color_desc . " to collection " . $mat->material_desc . PHP_EOL);
                $matColl = $this->getNamedList($mat->material_desc, 'Material Collection');
            } else {
                if ($fb > 1) $this->writeOut("Adding " . $color->color_desc . " to default (not in collection) list" . PHP_EOL);
                $matColl = $this->getNamedList($defCollName, 'Material Collection');
            }
            $matItem = $this->findLegacyMaterial($color->color_id);
            if ($fb > 1) $this->writeOut("Creating an adding link to collection list" . PHP_EOL);
            $newLink = $this->getSubItem($matItem->getListItemId(), $matColl);

            if ($fb > 1) $this->writeOut("Creating an adding collection list link to all collections list (of lists)" . PHP_EOL);
            $matColl->addListitem($newLink);
            if ($fb > 1) $this->writeOut("Persisting and flushing all collections list (of lists)" . PHP_EOL);
            $allMats = $this->getNamedList('All Materials', 'Materials');
            $this->getEntityManager()->persist($allMats);
            $this->getEntityManager()->flush();
        }

        return $this->_output;
    }

    public function setOutputType($type) {
        $this->_output = '';
        if($type == "file") {
            $this->resetOutFile();
        }
        $this->_outType = $type;
    }

    private function writeOut($text) {
        switch($this->_outType) {
            case('file'):
                $this->writeToFile($text);
                break;
            case('echo'):
                echo $text;
                break;
            case('buffer'):
            default:
                $this->_output .= $text;
                break;
        }
    }

    private function resetOutFile() {
        file_put_contents ( $this->defOutFile , '');
    }
    private function writeToFile($text) {
        if(!is_file($this->defOutFile)) {
            $this->resetOutFile();
        }
        file_put_contents( $this->defOutFile, $text, FILE_APPEND);
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
     * @throws \Exception on extra property accessor not found
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