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
        $allMats = $this->getMaterialsList();

        $materialTable = $this->getJoomlaTable('sx_color');
        $materialCollections = $this->getJoomlaTable('sx_material');

        foreach($materialTable->select() as $material) {
            $newMat = $this->getMaterialsItem($material->color_desc,$material->color_id);
            $allMats->addListitem($newMat);
        }
        $this->getEntityManager()->persist($allMats);
        $this->getEntityManager()->flush();
    }

    private function getMaterialsItem($name,$legacyId=null) {
        $mat = $this->getServiceLocator()->get('ListMapper')->getRepo('\\Application\\Entity\\Materials')->findOneBy(array('MaterialName' => $name, 'MaterialId' => $legacyId));
        if(!($mat instanceof \Application\Entity\Materials)) {
            $mat = new \Application\Entity\Materials();
            $mat->setMaterialName($name);
            $mat->setMaterialId($legacyId);
            $this->getEntityManager()->persist($mat);
            $this->getEntityManager()->flush();
        }
        return $mat;
    }
    /**
     * @return \Application\Entity\Types
     */
    private function getMaterialsType() {
        $type = $this->getServiceLocator()->get('TypeMapper')->findRecordByName('Materials');
        if(!($type instanceof \Application\Entity\Types)) {
            // create a new type for Materials
            $type = new \Application\Entity\Types();
            $type->setTypeName('Materials');
            $this->getEntityManager()->persist($type);
            $this->getEntityManager()->flush();
        }
        return $type;
    }

    /**
     * @return \Application\Entity\Lists
     */
    private function getMaterialsList() {
        $list = $this->getServiceLocator()->get('ListMapper')->findRecordByName('All Materials');
        if(!($list instanceof \Application\Entity\Lists)) {
            // create a new type for Materials
            $list = new \Application\Entity\Lists();
            $list->setListName('All Materials');
            $list->setType($this->getMaterialsType());
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
