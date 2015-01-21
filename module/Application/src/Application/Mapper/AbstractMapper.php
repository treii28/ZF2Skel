<?php
/**
 * Created by PhpStorm.
 * User: scottw
 * Date: 12/18/14
 * Time: 3:42 PM
 */

namespace Application\Mapper;

use Application\ServiceAbstract;

abstract class AbstractMapper extends ServiceAbstract
{

    /**
     * ENTITY_NAME should be filled in with the default entity for any inherited instances of the class
     */
    const ENTITY_NAME = '';

    public function __construct() {
        parent::__construct();
    }

    // <editor-fold desc="Doctrine 2 ORM service accessor overrides">

    /**
     * override for getRepo that will try to get a default entity name from this mapper
     *
     * @param string $entityName
     * @return DoctrineEntityRepository
     * @throws \Exception on Entity not found
     */
    public function getRepo($entityName = null) {
        if(is_null($entityName)) {
            $entityName = $this->getEntityName();
        }
        return parent::getRepo($entityName);
    }

    /**
     * @param string|null $mapperName
     * @return AbstractMapper
     * @throws \Exception on Mapper not found
     */
    public function getMapper($mapperName = null) {
        if(empty($mapperName)) {
            $mapperName = get_class($this); // parent will clean up mapperName
        }
        return parent::getMapper($mapperName);
    }

    // </editor-fold>

    //<editor-fold desc="Helper Functions">
    protected function _getMapperBaseName() {

        preg_match('/(\w+)Mapper$/', get_class($this), $m);
        return $m[1];
    }

    /**
     * will try to calculate the entity name or fall back to the defined name
     *
     * @return string
     */
    protected function getEntityName() {
        $cclass = '\\'.get_class($this);
        $centity = (defined($cclass::ENTITY_NAME)) ? $cclass::ENTITY_NAME : '';
        if(!empty($centity) && class_exists($centity)) {
            return $centity;
        } elseif(class_exists('Application\\Entity\\'.$this->_getMapperBaseName().'s')) {
            return 'Application\\Entity\\'.$this->_getMapperBaseName().'s';
        } elseif(class_exists('Application\\Entity\\'.$this->_getMapperBaseName().'es')) {
            return 'Application\\Entity\\' . $this->_getMapperBaseName() . 'es';
        } else {
            return self::ENTITY_NAME;
        }
    }

    // </editor-fold>

    // <editor-fold desc="Doctrine 2 ORM Helper functions">

    /**
     * override for findRecordById that will assume default entity if entityName is empty
     *
     * @param integer $id
     * @param string|null $entityName
     * @return null|object
     */
    public function findRecordById($id,$entityName = null)
    {
        if(is_null($entityName)) {
            $entityName = $this->getEntityName();
        }

        return parent::findRecordById($id, $entityName);
    }

    // </editor-fold>

}
