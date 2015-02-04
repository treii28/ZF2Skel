<?php
/**
 * Created by PhpStorm.
 * User: scottw
 * Date: 12/18/14
 * Time: 3:42 PM
 */

namespace Application;

use Zend\ServiceManager\ServiceLocatorAwareInterface as ZendServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface      as ZendServiceLocatorInterface;

use Doctrine\ORM\EntityRepository                    as DoctrineEntityRepository;
use Doctrine\ORM\EntityManager                       as DoctrineEntityManager;
use Doctrine\ORM\QueryBuilder                        as DoctrineQueryBuilder;

abstract class ServiceAbstract implements ZendServiceLocatorAwareInterface
{

    const ENTITY_NAME = '';

    // <editor-fold desc="Zend Framework 2 ServiceLocateAwareInterface properties">

    /**
     * @var ZendServiceLocatorInterface $service_manager
     */
    protected static $service_manager;

    // </editor-fold>

    public function __construct() { }

    // <editor-fold desc="Doctrine 2 ORM service handles">

    /**
     * @var DoctrineEntityManager $entity_manager
     */
    private static $entity_manager;

    /**
     * @var DoctrineQueryBuilder $query_builder
     */
    private static $query_builder;

    /**
     * @var AbstractMapper[] $mappers
     */
    private static $mappers = array();

    /**
     * @var DoctrineEntityRepository[] $repositories
     */
    private static $repositories = array();

    // </editor-fold>

    // <editor-fold desc="Zend Framework 2 ServiceLocateAwareInterface methods">

    /**
     * @param ZendServiceLocatorInterface $serviceLocator
     */
    public function setServiceLocator(ZendServiceLocatorInterface $serviceLocator)
    {
        self::$service_manager = $serviceLocator;
    }

    /**
     * @return ZendServiceLocatorInterface
     */
    public function getServiceLocator()
    {
        return self::$service_manager;
    }

    // </editor-fold>

    // <editor-fold desc="Doctrine 2 ORM service accessors">

    /**
     * @return DoctrineEntityManager
     */
    public function getEntityManager()
    {
        if (!(self::$entity_manager instanceof EntityManager)) {
            self::$entity_manager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        }

        return self::$entity_manager;
    }

    /**
     * @return DoctrineQueryBuilder
     */
    public function getQueryBuilder()
    {
        if (!(self::$query_builder instanceof QueryBuilder)) {
            self::$query_builder = $this->getEntityManager()->createQueryBuilder();
        }

        return self::$query_builder;
    }

    /**
     * @param string $entityName
     * @return DoctrineEntityRepository
     * @throws \Exception on Entity not found
     */
    public function getRepo($entityName) {
        if(!(class_exists($entityName))) {
            throw new \Exception(__METHOD__ . " unable to find repository, class '$entityName' not found");
        }
        if(!(isset(self::$repositories[$entityName]) && (self::$repositories[$entityName] instanceof EntityRepository))) {
            self::$repositories[$entityName] = $this->getEntityManager()->getRepository($entityName);
        }
        return self::$repositories[$entityName];
    }

    /**
     * @param string|null $mapperName
     * @return AbstractMapper
     * @throws \Exception on Mapper not found
     */
    public function getMapper($mapperName) {
        // normalize the mapperName to use for finding the mapper and assigning the cache key
        // make sure 'Mapper' is on the end of the name
        if(!(preg_match('/Mapper$/', $mapperName))) {
            $mapperName .= 'Mapper';
        }
        // remove any namespace prefix
        if(preg_match('/^(\\\\)?.*\\\\/', $mapperName)) {
            $mapperName = preg_replace('/^(\\\\)?.*\\\\/', '', $mapperName);
        }

        if(!(isset(self::$mappers[$mapperName]) && (self::$mappers[$mapperName] instanceof AbstractMapper))) {
            $mapper = $this->getServiceLocator()->get($mapperName);
            if(!($mapper instanceof \Application\Mapper\AbstractMapper)) {
                throw new \Exception(__METHOD__." mapper '$mapperName' not found");
            }
            self::$mappers[$mapperName] = $mapper;
        }
        return self::$mappers[$mapperName];
    }

    // </editor-fold>

    // <editor-fold desc="Doctrine 2 ORM Helper functions">

    /**
     * find a given record for a given entity
     *
     * @param integer, $id
     * @param string $entityName
     * @return null|object
     */
    public function findRecordById($id,$entityName)
    {
        return $this->getEntityManager()->find($entityName,$id);
    }

    public function findAll($entityName) {
        return $this->getRepo($entityName)->findAll();
    }

    public function persistInstance($instance) {
        $this->getEntityManager()->persist($instance);
        return $this->getEntityManager()->flush();
    }

    public function removeInstance($instance) {
        $this->getEntityManager()->remove($instance);
        return $this->getEntityManager()->flush();
    }

    // </editor-fold>

}
