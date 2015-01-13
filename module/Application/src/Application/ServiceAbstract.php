<?php
/**
 * Created by PhpStorm.
 * User: scottw
 * Date: 1/13/15
 * Time: 3:03 PM
 */

namespace Application;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\QueryBuilder;


class ServiceAbstract implements ServiceLocatorAwareInterface {
    protected static $service_manager;
    /**
     * @var \Doctrine\ORM\EntityManager; $entity_manager
     */
    private static $entity_manager;
    /**
     * @var \Doctrine\ORM\QueryBuilder $query_builder
     */
    private static $query_builder;

    /**
     * @var AbstractMapper[] $repository
     */
    private static $mappers = array();

    /**
     * @var \Doctrine\ORM\EntityRespository[] $repository
     */
    private static $repositories = array();

    public function __construct() { }

    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        self::$service_manager = $serviceLocator;
    }

    public function getServiceLocator()
    {
        return self::$service_manager;
    }

    /**
     * @return \Doctrine\ORM\EntityManager
     */
    public function getEntityManager()
    {
        if (!(self::$entity_manager instanceof EntityManager)) {
            self::$entity_manager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        }

        return self::$entity_manager;
    }

    /**
     * @return \Doctrine\ORM\QueryBuilder
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
     * @return EntityRepository|\Doctrine\ORM\EntityRepository
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
     * @param string $mapperName
     * @return AbstractMapper
     * @throws \Exception on Mapper not found
     */
    public function getMapper($mapperName) {
        if(empty($mapperName)) {
            throw new \Exception(__METHOD__.' mapper name cannot be empty');
        }

        // normalize the mapperName to use for finding the mapper and assigning the cache key
        // remove any plural endings
        preg_replace('/(e)?s$/', '', $mapperName);
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
            if($mapper instanceof \Application\Mapper\AbstractMapper) {
                throw new \Exception(__METHOD__." mapper '$mapperName' not found");
            }
            self::$mappers[$mapperName] = $mapper;
        }
        return self::$mappers[$mapperName];
    }
}