<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Printers
 *
 * @ORM\Entity
 * @ORM\Table(name="Printers")
 */
class Printers extends ListItems
{
    /**
     * @var string
     *
     * @ORM\Column(name="PrinterName", type="string", length=64, nullable=false)
     */
    protected $PrinterName;

    /**
     * Get PrinterId
     *
     * @return integer
     */
    public function getPrinterId()
    {
        return $this->getMemberId();
    }

    /**
     * @param integer $printerId
     * @return ListXref
     */
    public function setPrinterId($printerId) {
        return $this->setMemberId($printerId);
    }

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
     * @return string
     */
    public function getItemEntity() {
        return __CLASS__;
    }
}
