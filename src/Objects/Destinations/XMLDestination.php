<?php

namespace DivineOmega\uxdm\Objects\Destinations;

use DivineOmega\uxdm\Interfaces\DestinationInterface;
use DOMDocument;
use DOMElement;

class XMLDestination implements DestinationInterface
{
    private $file;
    private $domDoc;
    private $domNode;

    public function __construct($file, DOMDocument $domDoc, DOMElement $rootElement, $rowElementName = 'row')
    {
        $this->file = $file;
        $this->domDoc = $domDoc;
        $this->rootElement = $rootElement;
        $this->rowElementName = $rowElementName;
    }

    public function putDataRows(array $dataRows)
    {
        foreach ($dataRows as $dataRow) {
            $dataItems = $dataRow->getDataItems();

            $dataRowDomElement = $this->rootElement->appendChild(new DOMElement($this->rowElementName));

            foreach ($dataItems as $dataItem) {
                $dataItemDomElement = new DOMElement($dataItem->fieldName, htmlspecialchars($dataItem->value));
                $dataRowDomElement->appendChild($dataItemDomElement);
            }
        }
    }

    public function finishMigration()
    {
        file_put_contents($this->file, $this->domDoc->saveXML());
    }
}
