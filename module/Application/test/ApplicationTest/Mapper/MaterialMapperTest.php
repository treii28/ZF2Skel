<?php
/**
 * Created by PhpStorm.
 * User: scottw
 * Date: 2/3/15
 * Time: 5:58 PM
 */

namespace ApplicationTest\Mapper;

require_once(realpath(__DIR__ . "/../") . "/TestingAbstract.php");

use ApplicationTest\TestingAbstract;

class MaterialMapperTest extends TestingAbstract {

    protected function setUp() {
        parent::setUp();
    }

    protected function tearDown() {
        parent::tearDown();
    }

    public function testGetMaterialsByOption() {
        $this->assertInstanceOf('\\Application\\Mapper\\MaterialMapper', $this->getMapper());
        $materials = $this->getMapper()->getMaterialsByOption("Leather Materials");
        $this->assertTrue(is_array($materials));
        $this->assertEquals(82,count($materials));
        $firstMaterial = $materials[0];
        $this->assertEquals($firstMaterial->getOption("Leather Materials")->getContent(), 1);
    }

    /**
     * @return \Application\Mapper\MaterialMapper
     */
    private function getMapper() {
        return $this->serviceManager->get('MaterialMapper');
    }
}
