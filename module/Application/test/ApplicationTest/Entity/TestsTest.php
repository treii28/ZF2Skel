<?php
/**
 * Created by PhpStorm.
 * User: scottw
 * Date: 1/13/15
 * Time: 5:35 PM
 */

namespace ApplicationTest\Entity;

require_once(realpath(__DIR__ . "/../") . "/TestingAbstract.php");

use ApplicationTest\TestingAbstract;
use Application\Entity\Tests;


class TestsTest extends TestingAbstract {
    protected function setup() {
        parent::setup();
    }

    public function testsTest() {
        $recordCount = count($this->entityRepository->findAll());
        $newTest = new Tests();
        $this->assertInstanceOf('\\Application\\Entity\\Tests', $newTest);
        $newTest->setMyInt(5);
        $newTest->setMyDec(3.14);
        $newTest->setMyStr("foo");
        $this->entityManager->persist($newTest);
        $this->entityManager->flush($newTest);
        $recordCount++;
        $this->assertEquals($recordCount, count($this->entityRepository->findAll()));
        $newId = $newTest->getId();
        $this->assertTrue(is_int($newId));
        $this->assertGreaterThan(0, $newId);

        $retTest = $this->entityRepository->find($newId);
        $this->assertInstanceOf('\\Application\\Entity\\Tests', $retTest);
        $this->assertEquals($newId, $retTest->getMyId());
        $this->assertEquals(5, $retTest->getMyInt());
        $this->assertEquals(3.14, $retTest->getMyDec());
        $this->assertEquals("foo", $retTest->getMyStr());

        $this->assertEquals($newTest, $retTest);

        $recordCount--;
        $this->entityManager->remove($newTest);
        $this->entityManager->flush();
        $this->assertEquals($recordCount, count($this->entityRepository->findAll()));

        $this->assertEquals($newTest, $retTest);
    }
}
