<?php
/**
 * Created by PhpStorm.
 * User: scottw
 * Date: 12/19/14
 * Time: 4:08 PM
 */

namespace Application\Controller;

//use Zend\View\Model\ViewModel;
use Zend\Mvc\Controller\AbstractActionController;

class AbstractController  extends AbstractActionController
{
    const MAPPER_NAME = '';

    /**
     * @var \Application\Mapper\AbstractMapper $_Mapper
     */
    protected $_defMapper;

    public function __construct() {
        //$this->getDefMapper();
    }

    protected function _getBaseName() {
        preg_match('/(\w+)Controller$/', get_class($this), $m);
        return $m[1];
    }

    /**
     * will try to calculate the mapper name or fall back to the defined name
     *
     * @return string
     */
    protected function _getMapperName() {
        if(class_exists('Application\\Mapper\\'.$this->_getBaseName())) {
            return 'Application\\Entity\\' . $this->_getBaseName();
        } elseif(preg_replace('/Controller/i','Mapper',get_called_class())) {
            return preg_replace('/Controller/i','Mapper',get_called_class());
        } else {
            return self::MAPPER_NAME;
        }
    }

    /**
     * @return \Application\Mapper\AbstractMapper
     */
    protected function getDefMapper() {
        if(!$this->_defMapper) {
            $this->_defMapper = $this->getServiceLocator()->get($this->_getBaseName()."Mapper");
        }
        return $this->_defMapper;
    }

    /**
     * local alias wrapper to AbstractMapper->getMapper($mapperName)
     *
     * @param null|string $mapperName
     * @returns \Application\Mapper\AbstractMapper
     * @throws \Exception
     */
    public function getMapper($mapperName = null) {
        if(empty($mapperName)) {
            return $this->getDefMapper();
        } else {
            return $this->getDefMapper()->getMapper($mapperName);
        }
    }

    /**
     * local alias wrapper to AbstractMapper->getEntityManager()
     *
     * @return \Doctrine\ORM\EntityManager
     */
    public function getEntityManager()
    {
        return $this->getDefMapper()->getEntityManager();
    }

    /**
     * local alias wrapper to AbstractMapper->getRepo()
     *
     * @param null|string $repoName
     * @return \Doctrine\ORM\EntityRepository
     * @throws \Exception
     */
    public function getRepo($repoName = null) {
        return $this->getDefMapper()->getRepo($repoName);
    }

    /**
     * local alias wrapper to AbstractMapper-getQueryBuilder()
     *
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getQueryBuilder() {
        return $this->getDefMapper()->getQueryBuilder();
    }

    /**
     * @param array|null $alsoignore
     * @return array
     */
    public function getActionNames($alsoignore=null) {
        $actionList = array();
        $ignore = array('notFoundAction','getMethodFromAction');
        if(is_array($alsoignore)) {
            $ignore = array_merge($ignore, $alsoignore);
        }
        foreach(get_class_methods(get_called_class()) as $method) {
            if(!in_array($method, $ignore) && preg_match('/^([\w\d_]*)Action$/', $method, $matches)) {
                array_push($actionList, $matches[1]);
            }
        }
        return $actionList;
    }
}