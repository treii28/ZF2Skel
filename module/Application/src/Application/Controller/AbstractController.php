<?php
/**
 * Created by PhpStorm.
 * User: scottw
 * Date: 12/19/14
 * Time: 4:08 PM
 */

namespace Application\Controller;

use Zend\View\Model\ViewModel;

use Zend\Mvc\Controller\AbstractActionController;

class AbstractController  extends AbstractActionController
{
    const MAPPER_NAME = '';
    /**
     * @var \Doctrine\ORM\EntityManager $entity_manager
     */
    protected $entity_manager;

    /**
     * @var \Application\Mapper\AbstractMapper $_Mapper
     */
    protected $_Mapper;

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
    protected function getMapper() {
        if(!$this->_Mapper) {
            $this->_Mapper = $this->getServiceLocator()->get($this->_getBaseName()."Mapper");
        }
        return $this->_Mapper;
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
}