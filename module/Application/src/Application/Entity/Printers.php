<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Printers
 *
 * @ORM\Table(name="Printers")
 * @ORM\Entity
 */
class Printers
{
    /**
     * @var string
     *
     * @ORM\Column(name="PrinterName", type="string", length=64, nullable=false)
     */
    private $PrinterName;

    /**
     * @var integer
     *
     * @ORM\Column(name="PrinterId", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $PrinterId;


    /**
     * Set PrinterName
     *
     * @param string $printerName
     * @return Printers
     */
    public function setPrinterName($printerName)
    {
        $this->PrinterName = $printerName;

        return $this;
    }

    /**
     * Get PrinterName
     *
     * @return string 
     */
    public function getPrinterName()
    {
        return $this->PrinterName;
    }

    /**
     * Get PrinterId
     *
     * @return integer 
     */
    public function getPrinterId()
    {
        return $this->PrinterId;
    }

    // alias functions

    public function getId() {
        return $this->getPrinterId();
    }

    public function getName() {
        return $this->getPrinterName();
    }
}
