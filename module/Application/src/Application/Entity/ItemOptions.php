<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ItemOptions
 *
 * @ORM\Entity
 * @ORM\Table(name="ItemOptions", uniqueConstraints={ @ORM\UniqueConstraint(name="UniqueItemOpt_idx", columns={"ItemrefId", "Description"}) })
 */
class ItemOptions
{
    /**
     * @var integer $ItemOptionId
     *
     * @ORM\Column(name="ItemOptionId", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $ItemOptionId;

    /**
     * @var integer $ItemfrefId
     *
     * @ORM\Column(name="ItemrefId", type="integer", options={"unsigned":true}, nullable=false)
     * @ORM\OneToOne(targetEntity="ListItems")
     * @ORM\JoinColumn(name="ItemrefId", referencedColumnName="ListItemId")
     */
    protected $ItemrefId;

    /**
     * @var string $Description
     *
     * @ORM\Column(name="Description", type="string", length=128, nullable=false)
     */
    protected $Description;

    /**
     * @var string $Content
     *
     * @ORM\Column(name="Content", type="boolean", nullable=false)
     */
    protected $Content;

    public function __construct() {
        parent::__construct();
        $this->setItemrefEntity(__CLASS__);
    }

    /**
     * Get ItemOptionId
     *
     * @return integer
     */
    public function getItemOptionId()
    {
        return $this->ItemOptionId;
    }

    /**
     * Set ItemrefId
     *
     * @param string $itemrefId
     * @return ItemOptions
     */
    public function setItemrefId($itemrefId)
    {
        $this->ItemrefId = $itemrefId;

        return $this;
    }

    /**
     * Get ItemrefId
     *
     * @return string
     */
    public function getItemrefId()
    {
        return $this->ItemrefId;
    }

    /**
     * Set Description
     *
     * @param string $description
     * @return Booleans
     */
    public function setDescription($description)
    {
        $this->Description = $description;

        return $this;
    }

    /**
     * Get Description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->Description;
    }

    /**
     * Set Content
     *
     * @param string $content
     * @return ItemOptions
     */
    public function setContent($content)
    {
        $this->Content = $content;

        return $this;
    }

    /**
     * Get Content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->Content;
    }

    /**
     * GenericInterface alias method for primary Id
     * @return int
     */
    public function getId() {
        return $this->getItemOptionId();
    }

    public function getItemEntity() {
        return __CLASS__;
    }
}
