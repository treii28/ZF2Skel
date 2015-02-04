<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Printers
 *
 * @ORM\Entity
 * @ORM\Table(name="Printers", uniqueConstraints={
 *      @ORM\UniqueConstraint(name="UniquePrinterId_idx", columns={"PrinterId"}),
 *      @ORM\UniqueConstraint(name="UniquePrinterName_idx", columns={"PrinterName"})
 *   }
 * )
 */
class Printers extends ListItems
{
    /**
     * legacy unique identifier
     *
     * @var integer
     *
     * @ORM\Column(name="PrinterId", type="integer", nullable=true)
     */
    protected $PrinterId;

    /**
     * @var string
     *
     * @ORM\Column(name="PrinterName", type="string", length=64, nullable=false)
     */
    protected $PrinterName;

    public function __construct() {
        parent::__construct();
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

    /**
     * @param integer $printerId
     * @return ListItems
     */
    public function setPrinterId($printerId)
    {
        $this->PrinterId = $printerId;

        return $this;
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
}
