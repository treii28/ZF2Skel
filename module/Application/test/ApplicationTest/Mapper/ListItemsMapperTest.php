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

class ListItemsMapperTest extends TestingAbstract {
    /**
     * @var ListItemMapper $mapper
     */
    protected $mapper;

    protected function setUp() {
        parent::setUp();
    }
    protected function tearDown() {
        parent::tearDown();
    }

    public function testListItemMapper() {
        $this->assertInstanceOf('\\Application\\Mapper\\ListItemMapper', $this->getMapper());
        $item = $this->getMapper()->findRecordById(1);
        $ic = get_class($item);
    }

    /**
     * @return \Application\Mapper\ListItemMapper;
     */
    private function getMapper() {
        return $this->serviceManager->get('ListItemMapper');
    }
}
