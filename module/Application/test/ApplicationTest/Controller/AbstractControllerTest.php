<?php
/**
 * Created by PhpStorm.
 * User: scottw
 * Date: 1/13/15
 * Time: 5:59 PM
 */

namespace ApplicationTest\Controller;

use Application\Controller\AbstractController;
use ApplicationTest\Bootstrap;
use Zend\Mvc\Router\Http\TreeRouteStack as HttpRouter;
use Zend\Http\Request;
use Zend\Http\Response;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\RouteMatch;
use PHPUnit_Framework_TestCase;

class AbstractControllerTest extends \PHPUnit_Framework_TestCase {

}

class TestController extends AbstractController {

}
