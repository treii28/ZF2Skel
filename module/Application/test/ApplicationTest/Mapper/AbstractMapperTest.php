<?php
/**
 * Created by PhpStorm.
 * User: scottw
 * Date: 1/13/15
 * Time: 5:42 PM
 */

namespace ApplicationTest\Mapper;

use Application\Mapper\AbstractMapper;
use ApplicationTest\Bootstrap;
use Zend\Mvc\Router\Http\TreeRouteStack as HttpRouter;
use Zend\Http\Request;
use Zend\Http\Response;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\RouteMatch;
use PHPUnit_Framework_TestCase;


class AbstractMapperTest extends \PHPUnit_Framework_TestCase {

}

class TestMapper extends AbstractMapper {
    const ENTITY_NAME = 'Tests';
}