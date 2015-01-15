<?php
/**
 * Created by PhpStorm.
 * User: scottw
 * Date: 1/13/15
 * Time: 5:42 PM
 */

namespace ApplicationTest\Mapper;

require_once(realpath(__DIR__ . "/../") . "/TestingAbstract.php");

use ApplicationTest\TestingAbstract;
use Application\Mapper\AbstractMapper;


class AbstractMapperTest extends TestingAbstract {
    protected function setUp() {
        parent::setUp();
    }
    protected function tearDown() {
        parent::tearDown();
    }

    public function testTestMapper() {
        $this->assertTrue(true);
    }
}

class TestMapper extends AbstractMapper {
    const ENTITY_NAME = 'Tests';
}