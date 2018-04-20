<?php

require_once __DIR__.'/../../../vendor/autoload.php';

use DivineOmega\uxdm\Objects\Destinations\AssociativeArrayDestination;
use DivineOmega\uxdm\Objects\Migrator;
use DivineOmega\uxdm\Objects\Sources\AssociativeArraySource;

$sourceArray = [
    ['name' => 'James', 'height' => 1.88],
    ['name' => 'Frank', 'height' => 1.73],
];
$assocArraySource = new AssociativeArraySource($sourceArray);

$destinationArray = [];
$assocArrayDestination = new AssociativeArrayDestination($destinationArray);

$migrator = new Migrator();
$migrator->setSource($assocArraySource)
         ->setDestination($assocArrayDestination)
         ->setDataItemManipulator(function ($dataItem) {
             if ($dataItem->fieldName == 'height') {
                 $dataItem->value = round($dataItem->value, 1);
             }
         })
         ->withProgressBar()
         ->migrate();

var_dump($destinationArray);
