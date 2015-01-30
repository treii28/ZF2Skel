<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Booleans
 *
 * @ORM\Entity
 * @ORM\Table(name="Booleans", uniqueConstraints={ @ORM\UniqueConstraint(name="UniqueDesc_idx", columns={"Description" }) })
 */
class Booleans extends ListItems
{
    /**
     * @var string $Description
     *
     * @ORM\Column(name="Description", type="string", length=128, nullable=true)
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
        $this->setEntityName(__CLASS__);
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
     * @return Booleans
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
