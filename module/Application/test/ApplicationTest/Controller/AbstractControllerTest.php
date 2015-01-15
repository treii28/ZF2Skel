<?php
/**
 * Created by PhpStorm.
 * User: scottw
 * Date: 1/13/15
 * Time: 5:59 PM
 */

namespace ApplicationTest\Controller;

require_once(realpath(__DIR__ . "/../") . "/TestingAbstract.php");

use ApplicationTest\TestingAbstract;
use Application\Controller\AbstractController;
use Zend\Mvc\Router\Http\TreeRouteStack as HttpRouter;
use Zend\Http\Request;
use Zend\Http\Response;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\RouteMatch;

class AbstractControllerTest extends TestingAbstract {

    protected $controller;
    protected $request;
    protected $response;
    protected $routeMatch;
    protected $event;

    protected function setUp()
    {
        $this->controller = new TestController();
        $this->request    = new Request();
        $this->routeMatch = new RouteMatch(array('controller' => 'test'));
        $this->event      = new MvcEvent();
        $config = $this->serviceManager->get('Config');
        $routerConfig = isset($config['router']) ? $config['router'] : array();
        $router = HttpRouter::factory($routerConfig);

        $this->event->setRouter($router);
        $this->event->setRouteMatch($this->routeMatch);
        $this->controller->setEvent($this->event);
        $this->controller->setServiceLocator($this->serviceManager);
    }

    public function testAbstractController() {
        $this->assertTrue(true);
    }

}

class TestController extends AbstractController {
}
