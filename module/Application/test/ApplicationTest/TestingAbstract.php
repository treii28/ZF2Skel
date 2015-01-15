<?php
/**
 * Created by PhpStorm.
 * User: scottw
 * Date: 1/14/15
 * Time: 12:43 PM
 */

namespace ApplicationTest;

require_once(realpath(__DIR__ . "/../") . "/Bootstrap.php");

use ApplicationTest\Bootstrap;
use PHPUnit_Framework_TestCase;

abstract class TestingAbstract extends \PHPUnit_Framework_TestCase {
    /**
     * @var \Zend\ServiceManager\ServiceManager $serviceManager
     */
    protected $serviceManager;
    /**
     * @var \Doctrine\ORM\EntityManager $entityManager
     */
    protected $entityManager;

    protected function setUp() {
        parent::setUp();
        $this->serviceManager = Bootstrap::getServiceManager();
        $this->entityManager  = $this->serviceManager->get('Doctrine\ORM\EntityManager');
    }

    protected function tearDown() {
        parent::tearDown();
    }
}