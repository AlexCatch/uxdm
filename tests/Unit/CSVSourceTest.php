<?php

use PHPUnit\Framework\TestCase;
use RapidWeb\uxdm\Objects\Sources\CSVSource;

final class CSVSourceTest extends TestCase
{
    private function createCSVSource()
    {
        return new CSVSource(__DIR__.'/Data/source.csv');
    }

    public function testGetFields()
    {
        $source = $this->createCSVSource();

        $this->assertEquals(['Title', 'Author'], $source->getFields());
    }

    public function testGetDataRows()
    {
        $source = $this->createCSVSource();

        $dataRows = $source->getDataRows(1, ['Title', 'Author']);

        $this->assertCount(2, $dataRows);

        $dataItems = $dataRows[0]->getDataItems();

        $this->assertCount(2, $dataItems);

        $this->assertEquals('Title', $dataItems[0]->fieldName);
        $this->assertEquals('Adventures Of Me', $dataItems[0]->value);

        $this->assertEquals('Author', $dataItems[1]->fieldName);
        $this->assertEquals('Jordan Hall', $dataItems[1]->value);

        $dataItems = $dataRows[1]->getDataItems();

        $this->assertCount(2, $dataItems);

        $this->assertEquals('Title', $dataItems[0]->fieldName);
        $this->assertEquals('All The Things', $dataItems[0]->value);

        $this->assertEquals('Author', $dataItems[1]->fieldName);
        $this->assertEquals('Mr Bear', $dataItems[1]->value);

        $dataRows = $source->getDataRows(2, ['Title', 'Author']);

        $this->assertCount(0, $dataRows);
    }

    public function testGetDataRowsOnlyOneField()
    {
        $source = $this->createCSVSource();

        $dataRows = $source->getDataRows(1, ['Author']);

        $this->assertCount(2, $dataRows);

        $dataItems = $dataRows[0]->getDataItems();

        $this->assertCount(1, $dataItems);

        $this->assertEquals('Author', $dataItems[0]->fieldName);
        $this->assertEquals('Jordan Hall', $dataItems[0]->value);

        $dataItems = $dataRows[1]->getDataItems();

        $this->assertCount(1, $dataItems);

        $this->assertEquals('Author', $dataItems[0]->fieldName);
        $this->assertEquals('Mr Bear', $dataItems[0]->value);

        $dataRows = $source->getDataRows(2, ['Author']);

        $this->assertCount(0, $dataRows);
    }
}
