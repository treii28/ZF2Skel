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
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\QueryBuilder;

class AbstractMapper implements ServiceLocatorAwareInterface
{
    const ENTITY_NAME = '';

    protected $service_manager;
    /**
     * @var \Doctrine\ORM\EntityManager; $entity_manager
     */
    private $entity_manager;
    /**
     * @var \Doctrine\ORM\QueryBuilder $query_builder
     */
    private $query_builder;

    /**
     * @var \Doctrine\ORM\EntityRespository[] $repository
     */
    private $repositories = array();

    public function __construct() { }

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
     * @return \Doctrine\ORM\EntityManager
     */
    public function getEntityManager()
    {
        if (!($this->entity_manager instanceof EntityManager)) {
            $this->entity_manager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        }

        return $this->entity_manager;
    }

    /**
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getQueryBuilder()
    {
        if (!($this->query_builder instanceof QueryBuilder)) {
            $this->query_builder = $this->getEntityManager()->createQueryBuilder();
        }

        return $this->query_builder;
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
        $cclass = '\\'.get_called_class();
        $centity = (defined($cclass::ENTITY_NAME)) ? $cclass::ENTITY_NAME : '';
        if(!empty($centity) && class_exists($centity)) {
            return $centity;
        } elseif(class_exists('Application\\Entity\\'.$this->_getBaseName().'s')) {
            return 'Application\\Entity\\'.$this->_getBaseName().'s';
        } elseif(class_exists('Application\\Entity\\'.$this->_getBaseName().'es')) {
            return 'Application\\Entity\\' . $this->_getBaseName() . 'es';
        } else {
            return self::ENTITY_NAME;
        }
    }

    /**
     * @param null|string $entity_name
     * @return EntityRepository|\Doctrine\ORM\EntityRespository
     * @throws \Exception on Entity not found
     */
    public function getRepo($entity_name = null) {
        if(is_null($entity_name)) {
            $entity_name = $this->_getEntityName();
        }
        if(!(class_exists($entity_name))) {
            throw new \Exception(__METHOD__ . " unable to find repository, class '$entity_name' not found");
        }
        if(!($this->repositories[$entity_name] instanceof EntityRepository)) {
            $this->repositories[$entity_name] = $this->getEntityManager()->getRepository($entity_name);
        }
        return $this->repositories[$entity_name];
    }
}
