<?php
/**
 * Created by PhpStorm.
 * User: scottw
 * Date: 12/18/14
 * Time: 3:42 PM
 */

namespace Application\Mapper;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class AbstractMapper implements ServiceLocatorAwareInterface
{
    const ENTITY_NAME = '';

    protected $service_manager;
    /**
     * @var \Doctrine\ORM\EntityManager; $em
     */
    private $entity_manager;

    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->service_manager = $serviceLocator;
    }

    public function getServiceLocator()
    {
        return $this->service_manager;
    }

    public function findRecordById($id)
    {
        return $this->getEntityManager()->find($this->_getEntityName(),$id);
    }

    /**
     * @return array|\Doctrine\ORM\EntityManager
     */
    public function getEntityManager()
    {
        if (!($this->entity_manager instanceof \Doctrine\ORM\EntityManager)) {
            $this->entity_manager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        }

        return $this->entity_manager;
    }

    public function findAll() {
        return $this->getEntityManager()->getRepository($this->_getEntityName())->findAll();
    }

    public function persistInstance($instance) {
        $this->getEntityManager()->persist($instance);
        return $this->getEntityManager()->flush();
    }

    public function removeInstance($instance) {
        $this->getEntityManager()->remove($instance);
        return $this->getEntityManager()->flush();
    }

    protected function _getBaseName() {
        preg_match('/(\w+)Mapper$/', get_class($this), $m);
        return $m[1];
    }

    /**
     * will try to calculate the entity name or fall back to the defined name
     *
     * @return string
     */
    protected function _getEntityName() {
        if(class_exists('Application\\Entity\\'.$this->_getBaseName().'s')) {
            return 'Application\\Entity\\'.$this->_getBaseName().'s';
        } elseif(class_exists('Application\\Entity\\'.$this->_getBaseName().'es')) {
            return 'Application\\Entity\\'.$this->_getBaseName().'es';
        } else {
            return self::ENTITY_NAME;
        }
    }
}
