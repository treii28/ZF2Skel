<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Strings
 *
 * @ORM\Entity
 * @ORM\Table(name="Strings", uniqueConstraints={ @ORM\UniqueConstraint(name="UniqueDesc_idx", columns={"Description" }) })
 */
class Strings extends ListItems
{
    /**
     * @var string
     *
     * @ORM\Column(name="Description", type="string", length=128, nullable=true)
     */
    protected $Description;

    /**
     * @var string
     *
     * @ORM\Column(name="Content", type="string", length=64, nullable=false)
     */
    protected $Content;

    public function __construct() {
        parent::__construct();
        $this->setEntityName(__CLASS__);
    }

    /**
     * Set Description
     *
     * @param string $description
     * @return Strings
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
     * @return Strings
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

    public function getItemEntity() {
        return __CLASS__;
    }
}
