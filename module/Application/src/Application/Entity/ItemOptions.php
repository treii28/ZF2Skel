<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ItemOptions
 *
 * @ORM\Entity
 * @ORM\Table(name="ItemOptions", uniqueConstraints={ @ORM\UniqueConstraint(name="UniqueItemOpt_idx", columns={"ListItemId", "Description"}) })
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
     * @var integer $ListItemId
     *
     * @ORM\Column(name="ListItemId", type="integer", options={"unsigned":true}, nullable=true)
     */
    protected $ListItemId;

    /**
     * @var string $Description
     *
     * @ORM\Column(name="Description", type="string", length=128, nullable=false)
     */
    protected $Description;

    /**
     * @var boolean $Content
     *
     * @ORM\Column(name="Content", type="boolean", nullable=false)
     */
    protected $Content;

    public function __construct() {
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
     * Set ListItemId
     *
     * @param string $listitemId
     * @return ItemOptions
     */
    public function setListItemId($listitemId)
    {
        $this->ListItemId = $listitemId;

        return $this;
    }

    /**
     * Get ListItemId
     *
     * @return string
     */
    public function getListItemId()
    {
        return $this->ListItemId;
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
}
