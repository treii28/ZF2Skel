<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Products
 *
 * @ORM\Table(name="Products")
 * @ORM\Entity
 */
class Products
{
    /**
     * @var integer
     *
     * @ORM\Column(name="product_parent_id", type="integer", nullable=false)
     */
    private $productParentId;

    /**
     * @var string
     *
     * @ORM\Column(name="product_sku", type="string", length=32, nullable=false)
     */
    private $productSKU;

    /**
     * @var string
     *
     * @ORM\Column(name="product_name", type="string", length=64, nullable=false)
     */
    private $productName;

    /**
     * @var string
     *
     * @ORM\Column(name="product_description", type="text", nullable=true)
     */
    private $productDesc;

    /**
     * @var string
     *
     * @ORM\Column(name="product_weight", type="decimal", precision=2, nullable=false)
     */
    private $productWeight;

    /**
     * @var string
     *
     * @ORM\Column(name="product_width", type="decimal", precision=2, nullable=false)
     */
    private $productWidth;

    /**
     * @var string
     *
     * @ORM\Column(name="product_length", type="decimal", precision=2, nullable=false)
     */
    private $productLength;

    /**
     * @var string
     *
     * @ORM\Column(name="product_height", type="decimal", precision=2, nullable=false)
     */
    private $productHeight;

    /**
     * @var boolean
     *
     * @ORM\Column(name="product_publish", type="boolean", nullable=false)
     */
    private $productPublish;

    /**
     * @var boolean
     *
     * @ORM\Column(name="product_is_sample", type="boolean", nullable=false)
     */
    private $productIsSample;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="cdate", type="datetime", nullable=true)
     */
    private $cDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="mdate", type="datetime", nullable=true)
     */
    private $mDate;

    /**
     * @var integer
     *
     * @ORM\Column(name="product_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $productId;


    /**
     * Set productParentId
     *
     * @param integer $productParentId
     * @return Products
     */
    public function setProductParentId($productParentId)
    {
        $this->productParentId = $productParentId;

        return $this;
    }

    /**
     * Get productParentId
     *
     * @return integer 
     */
    public function getProductParentId()
    {
        return $this->productParentId;
    }

    /**
     * Set productSKU
     *
     * @param string $productSKU
     * @return Products
     */
    public function setProductSKU($productSKU)
    {
        $this->productSKU = $productSKU;

        return $this;
    }

    /**
     * Get productSKU
     *
     * @return string 
     */
    public function getProductSKU()
    {
        return $this->productSKU;
    }

    /**
     * Set productName
     *
     * @param string $productName
     * @return Products
     */
    public function setProductName($productName)
    {
        $this->productName = $productName;

        return $this;
    }

    /**
     * Get productName
     *
     * @return string 
     */
    public function getProductName()
    {
        return $this->productName;
    }

    /**
     * Set productDesc
     *
     * @param string $productDesc
     * @return Products
     */
    public function setProductDesc($productDesc)
    {
        $this->productDesc = $productDesc;

        return $this;
    }

    /**
     * Get productDesc
     *
     * @return string 
     */
    public function getProductDesc()
    {
        return $this->productDesc;
    }

    /**
     * Set productWeight
     *
     * @param string $productWeight
     * @return Products
     */
    public function setProductWeight($productWeight)
    {
        $this->productWeight = $productWeight;

        return $this;
    }

    /**
     * Get productWeight
     *
     * @return string 
     */
    public function getProductWeight()
    {
        return $this->productWeight;
    }

    /**
     * Set productWidth
     *
     * @param string $productWidth
     * @return Products
     */
    public function setProductWidth($productWidth)
    {
        $this->productWidth = $productWidth;

        return $this;
    }

    /**
     * Get productWidth
     *
     * @return string 
     */
    public function getProductWidth()
    {
        return $this->productWidth;
    }

    /**
     * Set productLength
     *
     * @param string $productLength
     * @return Products
     */
    public function setProductLength($productLength)
    {
        $this->productLength = $productLength;

        return $this;
    }

    /**
     * Get productLength
     *
     * @return string 
     */
    public function getProductLength()
    {
        return $this->productLength;
    }

    /**
     * Set productHeight
     *
     * @param string $productHeight
     * @return Products
     */
    public function setProductHeight($productHeight)
    {
        $this->productHeight = $productHeight;

        return $this;
    }

    /**
     * Get productHeight
     *
     * @return string 
     */
    public function getProductHeight()
    {
        return $this->productHeight;
    }

    /**
     * Set productPublish
     *
     * @param boolean $productPublish
     * @return Products
     */
    public function setProductPublish($productPublish)
    {
        $this->productPublish = $productPublish;

        return $this;
    }

    /**
     * Get productPublish
     *
     * @return boolean 
     */
    public function getProductPublish()
    {
        return $this->productPublish;
    }

    /**
     * Set productIsSample
     *
     * @param boolean $productIsSample
     * @return Products
     */
    public function setProductIsSample($productIsSample)
    {
        $this->productIsSample = $productIsSample;

        return $this;
    }

    /**
     * Get productIsSample
     *
     * @return boolean 
     */
    public function getProductIsSample()
    {
        return $this->productIsSample;
    }

    /**
     * Set cDate
     *
     * @param \DateTime $cDate
     * @return Products
     */
    public function setCDate($cDate)
    {
        $this->cDate = $cDate;

        return $this;
    }

    /**
     * Get cDate
     *
     * @return \DateTime 
     */
    public function getCDate()
    {
        return $this->cDate;
    }

    /**
     * Set mDate
     *
     * @param \DateTime $mDate
     * @return Products
     */
    public function setMDate($mDate)
    {
        $this->mDate = $mDate;

        return $this;
    }

    /**
     * Get mDate
     *
     * @return \DateTime 
     */
    public function getMDate()
    {
        return $this->mDate;
    }

    /**
     * Get productId
     *
     * @return integer 
     */
    public function getProductId()
    {
        return $this->productId;
    }
}
