<?php
/**
 * Generic Entity for use in phpunit tests and with abstract classes
 */

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tests
 *
 * @ORM\Table(name="Tests", indexes={@ORM\Index(name="intStrIdx", columns={"myInt","myStr"})})
 * @ORM\Entity
 */
class Tests
{
    /**
     * @var integer $myId
     *
     * @ORM\Column(name="myId", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $myId;

    /**
     * @var int $myInt
     *
     * @ORM\Column(name="myInt", type="integer", nullable=true)
     */
    private $myInt;

    /**
     * @var int $myDec
     *
     * @ORM\Column(name="myDec", type="float", nullable=true)
     */
    private $myDec;

    /**
     * @var string $myStr
     *
     * @ORM\Column(name="myStr", type="string", length=64, nullable=true)
     */
    private $myStr;

    /**
     * Get primary id
     *
     * @return string
     */
    public function getMyId()
    {
        return $this->myId;
    }

    /**
     * alias to get primary id
     *
     * @return string
     */
    public function getId()
    {
        return $this->getMyId();
    }

    /**
     * Set myInt
     *
     * @param integer $num
     * @return Tests
     */
    public function setMyInt($num)
    {
        $this->myInt = $num;

        return $this;
    }

    /**
     * Get myInt
     *
     * @return integer
     */
    public function getMyInt()
    {
        return $this->myInt;
    }

    /**
     * Set myDec
     *
     * @param float $num
     * @return Tests
     */
    public function setMyDec($num)
    {
        $this->myDec = $num;

        return $this;
    }

    /**
     * Get myDec
     *
     * @return float
     */
    public function getMyDec()
    {
        return $this->myDec;
    }

    /**
     * Set myStr
     *
     * @param string $str
     * @return Tests
     */
    public function setMyStr($str)
    {
        $this->myStr = $str;

        return $this;
    }

    /**
     * Get myStr
     *
     * @return string
     */
    public function getMyStr()
    {
        return $this->myStr;
    }
}
