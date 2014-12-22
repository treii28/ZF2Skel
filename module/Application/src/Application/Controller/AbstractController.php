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
     * @var \Doctrine\ORM\EntityManager $_objectManager
     */
    protected $_objectManager;
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

}