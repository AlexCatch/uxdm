<?php

use DivineOmega\uxdm\Objects\DataItem;
use DivineOmega\uxdm\Objects\DataRow;
use DivineOmega\uxdm\Objects\Destinations\MarkdownDestination;
use PHPUnit\Framework\TestCase;
use DivineOmega\uxdm\Objects\Destinations\HtmlDestination;

final class HtmlDestinationTest extends TestCase
{
    private function createDataRows()
    {
        $faker = Faker\Factory::create();

        $dataRows = [];

        $dataRow = new DataRow();
        $dataRow->addDataItem(new DataItem('name', $faker->word));
        $dataRow->addDataItem(new DataItem('value', $faker->randomNumber));
        $dataRows[] = $dataRow;

        $dataRow = new DataRow();
        $dataRow->addDataItem(new DataItem('name', $faker->word));
        $dataRow->addDataItem(new DataItem('value', $faker->randomNumber));
        $dataRows[] = $dataRow;

        return $dataRows;
    }

    private function getExpectedFileContent(array $dataRows)
    {
        $expectedFileContent = '<table class="uxdm-table"><tr class="uxdm-fields"><th class="uxdm-field">name</th><th class="uxdm-field">value</th></tr>';

        foreach ($dataRows as $dataRow) {
            $expectedFileContent .= '<tr class="uxdm-values"><td class="uxdm-value">';
            $expectedFileContent .= $dataRow->getDataItemByFieldName('name')->value;
            $expectedFileContent .= '</td><td class="uxdm-value">';
            $expectedFileContent .= $dataRow->getDataItemByFieldName('value')->value;
            $expectedFileContent .= '</td></tr>';
        }

        $expectedFileContent .= '</table>';

        return $expectedFileContent;
    }

    public function testPutDataRows()
    {
        $dataRows = $this->createDataRows();

        $file = __DIR__.'/Data/destination.html';

        $destination = new HtmlDestination($file);
        $destination->putDataRows($dataRows);

        $fileContent = file_get_contents($file);

        $this->assertEquals($this->getExpectedFileContent($dataRows), $fileContent);
    }
}
