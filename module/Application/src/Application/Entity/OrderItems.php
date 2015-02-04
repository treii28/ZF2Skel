<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OrderItems
 *
 * @ORM\Table(name="OrderItems", indexes={@ORM\Index(name="orderOrderItemIdx", columns={"order_id"})})
 * @ORM\Entity
 */
class OrderItems
{
    /**
     * @var integer
     *
     * @ORM\Column(name="product_id", type="integer", nullable=false)
     */
    private $productId;

    /**
     * @var string
     *
     * @ORM\Column(name="order_item_name", type="string", length=64, nullable=false)
     */
    private $orderItemName;

    /**
     * @var integer
     *
     * @ORM\Column(name="quantity", type="integer", nullable=false)
     */
    private $itemQuantity;

    /**
     * @var string
     *
     * @ORM\Column(name="item_price", type="decimal", precision=2, nullable=false)
     */
    private $itemPrice;

    /**
     * @var string
     *
     * @ORM\Column(name="item_total_price", type="decimal", precision=2, nullable=false)
     */
    private $itemTotalPrice;

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
     * @ORM\Column(name="order_item_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $orderItemId;

    /**
     * @var \Application\Entity\Products
     *
     * @ORM\OneToOne(targetEntity="Application\Entity\Products")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="product_id", referencedColumnName="product_id", unique=true, onDelete="CASCADE")
     * })
     */
    private $product_id;

    /**
     * @var \Application\Entity\Orders
     *
     * @ORM\ManyToOne(targetEntity="Application\Entity\Orders")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="order_id", referencedColumnName="order_id", onDelete="CASCADE")
     * })
     */
    private $order;


    /**
     * Set productId
     *
     * @param integer $productId
     * @return OrderItems
     */
    public function setProductId($productId)
    {
        $this->productId = $productId;

        return $this;
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

    /**
     * Set orderItemName
     *
     * @param string $orderItemName
     * @return OrderItems
     */
    public function setOrderItemName($orderItemName)
    {
        $this->orderItemName = $orderItemName;

        return $this;
    }

    /**
     * Get orderItemName
     *
     * @return string 
     */
    public function getOrderItemName()
    {
        return $this->orderItemName;
    }

    /**
     * Set itemQuantity
     *
     * @param integer $itemQuantity
     * @return OrderItems
     */
    public function setItemQuantity($itemQuantity)
    {
        $this->itemQuantity = $itemQuantity;

        return $this;
    }

    /**
     * Get itemQuantity
     *
     * @return integer 
     */
    public function getItemQuantity()
    {
        return $this->itemQuantity;
    }

    /**
     * Set itemPrice
     *
     * @param string $itemPrice
     * @return OrderItems
     */
    public function setItemPrice($itemPrice)
    {
        $this->itemPrice = $itemPrice;

        return $this;
    }

    /**
     * Get itemPrice
     *
     * @return string 
     */
    public function getItemPrice()
    {
        return $this->itemPrice;
    }

    /**
     * Set itemTotalPrice
     *
     * @param string $itemTotalPrice
     * @return OrderItems
     */
    public function setItemTotalPrice($itemTotalPrice)
    {
        $this->itemTotalPrice = $itemTotalPrice;

        return $this;
    }

    /**
     * Get itemTotalPrice
     *
     * @return string 
     */
    public function getItemTotalPrice()
    {
        return $this->itemTotalPrice;
    }

    /**
     * Set cDate
     *
     * @param \DateTime $cDate
     * @return OrderItems
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
     * @return OrderItems
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
     * Get orderItemId
     *
     * @return integer 
     */
    public function getOrderItemId()
    {
        return $this->orderItemId;
    }

    /**
     * Set order
     *
     * @param \Application\Entity\Orders $order
     * @return OrderItems
     */
    public function setOrder(Orders $order = null)
    {
        $this->order = $order;

        return $this;
    }

    /**
     * Get order
     *
     * @return \Application\Entity\Orders 
     */
    public function getOrder()
    {
        return $this->order;
    }
}
