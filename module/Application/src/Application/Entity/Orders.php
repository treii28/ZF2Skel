<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Orders
 *
 * @ORM\Table(name="Orders", indexes={@ORM\Index(name="userOrderIdx", columns={"user_id"})})
 * @ORM\Entity
 */
class Orders
{
    /**
     * @var integer
     *
     * @ORM\Column(name="order_number", type="integer", nullable=true)
     */
    private $orderNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="order_subtotal", type="decimal", precision=2, nullable=false)
     */
    private $orderSubtotal;

    /**
     * @var string
     *
     * @ORM\Column(name="order_total", type="decimal", precision=2, nullable=false)
     */
    private $orderTotal;

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
     * @ORM\Column(name="order_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $orderId;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="Application\Entity\OrderItems", mappedBy="orderId", cascade={"all"})
     * @ORM\OrderBy({
     *     "product_id"="ASC",
     *     "quantity"="ASC"
     * })
     */
    private $OrderItems;

    /**
     * @var \Application\Entity\Users
     *
     * @ORM\ManyToOne(targetEntity="Application\Entity\Users")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="user_id", onDelete="CASCADE")
     * })
     */
    private $user;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->OrderItems = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set orderNumber
     *
     * @param integer $orderNumber
     * @return Orders
     */
    public function setOrderNumber($orderNumber)
    {
        $this->orderNumber = $orderNumber;

        return $this;
    }

    /**
     * Get orderNumber
     *
     * @return integer 
     */
    public function getOrderNumber()
    {
        return $this->orderNumber;
    }

    /**
     * Set orderSubtotal
     *
     * @param string $orderSubtotal
     * @return Orders
     */
    public function setOrderSubtotal($orderSubtotal)
    {
        $this->orderSubtotal = $orderSubtotal;

        return $this;
    }

    /**
     * Get orderSubtotal
     *
     * @return string 
     */
    public function getOrderSubtotal()
    {
        return $this->orderSubtotal;
    }

    /**
     * Set orderTotal
     *
     * @param string $orderTotal
     * @return Orders
     */
    public function setOrderTotal($orderTotal)
    {
        $this->orderTotal = $orderTotal;

        return $this;
    }

    /**
     * Get orderTotal
     *
     * @return string 
     */
    public function getOrderTotal()
    {
        return $this->orderTotal;
    }

    /**
     * Set cDate
     *
     * @param \DateTime $cDate
     * @return Orders
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
     * @return Orders
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
     * Get orderId
     *
     * @return integer 
     */
    public function getOrderId()
    {
        return $this->orderId;
    }

    /**
     * Add OrderItems
     *
     * @param \Application\Entity\OrderItems $orderItems
     * @return Orders
     */
    public function addOrderItem(\Application\Entity\OrderItems $orderItems)
    {
        $this->OrderItems[] = $orderItems;

        return $this;
    }

    /**
     * Remove OrderItems
     *
     * @param \Application\Entity\OrderItems $orderItems
     */
    public function removeOrderItem(\Application\Entity\OrderItems $orderItems)
    {
        $this->OrderItems->removeElement($orderItems);
    }

    /**
     * Get OrderItems
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getOrderItems()
    {
        return $this->OrderItems;
    }

    /**
     * Set user
     *
     * @param \Application\Entity\Users $user
     * @return Orders
     */
    public function setUser(\Application\Entity\Users $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Application\Entity\Users 
     */
    public function getUser()
    {
        return $this->user;
    }
}
