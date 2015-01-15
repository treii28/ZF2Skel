<?php
/**
 * Created by PhpStorm.
 * User: scottw
 * Date: 1/14/15
 * Time: 4:57 PM
 */

namespace ApplicationTest\Mapper;

require_once(realpath(__DIR__ . "/../") . "/TestingAbstract.php");

use ApplicationTest\TestingAbstract;
use Application\Mapper\ListItemMapper;

class ListItemsMapperTest extends TestingAbstract {
    /**
     * @var ListItemMapper $mapper
     */
    protected $mapper;

    protected function setUp() {
        parent::setUp();
        $this->mapper = $this->serviceManager->get('ListItemMapper');
    }
    protected function tearDown() {
        parent::tearDown();
    }

    public function testListItemMapper() {
        $this->assertInstanceOf('\\Application\\Mapper\\ListItemMapper', $this->mapper);
        $item = $this->mapper->findRecordById(1);
        $ic = get_class($item);
    }
}
