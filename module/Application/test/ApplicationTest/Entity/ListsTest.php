<?php
/**
 * Created by PhpStorm.
 * User: scottw
 * Date: 1/13/15
 * Time: 5:35 PM
 */

namespace ApplicationTest\Entity;

require_once(realpath(__DIR__ . "/../") . "/TestingAbstract.php");

use Application\Entity\Subitems;
use ApplicationTest\TestingAbstract;
use Application\Entity\Lists;
use Application\Entity\ListItems;
use Application\Entity\Types;

class ListsTest extends TestingAbstract {
    /**
     * @var Types $myType;
     */
    protected $myType;

    /**
     * @var ListItems $myListItem;
     */
    protected $myListItem;

    /**
     * @var Lists $myList;
     */
    protected $myList;

    protected function setUp() {
        parent::setUp();
        $this->entityRepository = $this->entityManager->getRepository('\\Application\\Entity\\Tests');
        $this->initEntities();
    }

    protected function tearDown() {
        $this->removeEntities();
        parent::tearDown();
    }

    protected function initEntities() {
        $this->myType = new Types();
        $this->myType->setTypeName("Test Type");
        $this->entityManager->persist($this->myType);
        $this->entityManager->flush();

        $this->myList = new Lists();
        $this->myList->setListName("Test List");
        $this->myList->setType($this->myType);
        $this->entityManager->persist($this->myList);
        $this->entityManager->flush();

        //$this->myListItem = new ListItems();
        //$this->myListItem->setList($this->myList);
        //$this->entityManager->persist($this->myListItem);
        //$this->entityManager->flush();
    }

    protected function removeEntities() {
        //$this->entityManager->remove($this->myListItem);
        //$this->entityManager->flush();
        $itemsCount = $this->myList->getListitems()->count();
        $this->myList->flushListitems();

        $this->entityManager->remove($this->myList);
        $this->entityManager->flush();

        $this->entityManager->remove($this->myType);
        $this->entityManager->flush();

    }

    /**
     * @group entities
     */
    public function testTypesEntity() {
        $this->assertInstanceOf('\\Application\\Entity\\Types', $this->myType);
        $this->assertEquals("Test Type", $this->myType->getTypeName());
    }

    /**
     * @group entities
     */
    public function testListItemsEntity() {
        $this->assertInstanceOf('\\Application\\Entity\\ListItems', $this->myListItem);
        $this->assertEquals($this->myListItem->getList(), $this->myList);
    }

    /**
     * @group entities
     */
    public function testDescriminatorTypes() {
        // Vals
        $myVal = new \Application\Entity\Vals();
        $this->assertInstanceOf('\\Application\\Entity\\Vals', $myVal);
        $myVal->setDescription("Test Value");
        $myVal->setContent(9876);

        $myVal->setList($this->myList);
        $this->entityManager->persist($myVal);
        $this->entityManager->flush();

        $this->myList->addListitem($myVal);
        $this->entityManager->flush();

        // Materials
        $myMaterial = new \Application\Entity\Materials();
        $this->assertInstanceOf('\\Application\\Entity\\Materials', $myMaterial);
        $myMaterial->setMaterialName("Test Material");
        $myMaterial->setMaterialId(123);

        $myMaterial->setList($this->myList);
        $this->entityManager->persist($myMaterial);
        $this->entityManager->flush();

        $this->myList->addListitem($myMaterial);
        $this->entityManager->flush();

        // Papers
        $myPaper = new \Application\Entity\Papers();
        $this->assertInstanceOf('\\Application\\Entity\\Papers', $myPaper);
        $myPaper->setPaperName("Test Paper");

        $myPaper->setList($this->myList);
        $this->entityManager->persist($myPaper);
        $this->entityManager->flush();

        $this->myList->addListitem($myPaper);
        $this->entityManager->flush();

        // Printers
        $myPrinter = new \Application\Entity\Printers();
        $this->assertInstanceOf('\\Application\\Entity\\Printers', $myPrinter);
        $myPrinter->setPrinterName("Test Printer");

        $myPrinter->setList($this->myList);
        $this->entityManager->persist($myPrinter);
        $this->entityManager->flush();

        $this->myList->addListitem($myPrinter);
        $this->entityManager->flush();

        // Subitems
        $mySubitem = new Subitems();
        $mySubitem->setSubitem($myPrinter);

        // Sublists

        // clean it up
        $this->myList->removeListitem($myVal);
        $this->myList->removeListitem($myMaterial);
        $this->myList->removeListitem($myPaper);
        $this->myList->removeListitem($myPrinter);
        $this->entityManager->flush();
    }

    /**
     * @group entities
     */
    public function testListsEntity() {
        $this->assertInstanceOf('\\Application\\Entity\\Lists', $this->myList);
        $this->assertEquals($this->myList->getType(), $this->myType);
        $this->assertEquals("Test List", $this->myList->getListName());
    }
}
