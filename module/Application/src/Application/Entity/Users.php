<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Users
 *
 * @ORM\Table(name="Users")
 * @ORM\Entity
 */
class Users
{
    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=64, nullable=false)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="first_name", type="string", length=32, nullable=false)
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="middle_name", type="string", length=32, nullable=true)
     */
    private $middleName;

    /**
     * @var string
     *
     * @ORM\Column(name="last_name", type="string", length=32, nullable=false)
     */
    private $lastName;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=32, nullable=false)
     */
    private $phone;

    /**
     * @var integer
     *
     * @ORM\Column(name="user_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $userId;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Application\Entity\Addresses", mappedBy="userId", cascade={"all"})
     * @ORM\OrderBy({
     *     "country"="ASC",
     *     "state"="ASC",
     *     "city"="ASC"
     * })
     */
    private $Addresses;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Application\Entity\Orders", mappedBy="userId", cascade={"all"})
     * @ORM\OrderBy({
     *     "cdate"="ASC"
     * })
     */
    private $Orders;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->Addresses = new \Doctrine\Common\Collections\ArrayCollection();
        $this->Orders = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Users
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     * @return Users
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string 
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set middleName
     *
     * @param string $middleName
     * @return Users
     */
    public function setMiddleName($middleName)
    {
        $this->middleName = $middleName;

        return $this;
    }

    /**
     * Get middleName
     *
     * @return string 
     */
    public function getMiddleName()
    {
        return $this->middleName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     * @return Users
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string 
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set phone
     *
     * @param string $phone
     * @return Users
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string 
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Get userId
     *
     * @return integer 
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Add Addresses
     *
     * @param Addresses $addresses
     * @return Users
     */
    public function addAddress(Addresses $addresses)
    {
        $this->Addresses[] = $addresses;

        return $this;
    }

    /**
     * Remove Addresses
     *
     * @param Addresses $addresses
     */
    public function removeAddress(Addresses $addresses)
    {
        $this->Addresses->removeElement($addresses);
    }

    /**
     * Get Addresses
     *
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getAddresses()
    {
        return $this->Addresses;
    }

    /**
     * Add Orders
     *
     * @param Orders $orders
     * @return Users
     */
    public function addOrder(Orders $orders)
    {
        $this->Orders[] = $orders;

        return $this;
    }

    /**
     * Remove Orders
     *
     * @param Orders $orders
     */
    public function removeOrder(Orders $orders)
    {
        $this->Orders->removeElement($orders);
    }

    /**
     * Get Orders
     *
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getOrders()
    {
        return $this->Orders;
    }
}
