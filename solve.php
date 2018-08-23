<?php

require __DIR__.'/vendor/autoload.php';

use TSP\NearestNeighbour\NearestNeighbour;
use TSP\Utils\Utils;

class ShortestTour
{
    /**
     * Main function, that gets the filename and starts the NearestNeighbour algorithm.
     *
     * @param string $fileName name of the file containing data we want to analize
     */
    public function execute($fileName)
    {
        $utils = new Utils();
        $citiesList = $utils->getCities($fileName);

        if (!$citiesList) {
            printf("\r\nError loading file.\r\n");

            return;
        }

        $arrLength = count($citiesList);

        $distancesMatrix = $utils->calculateDistances($citiesList, $arrLength);

        $nearestNeighbour = new NearestNeighbour();
        $citiesOrder = $nearestNeighbour->createTour($arrLength, $distancesMatrix, $citiesList);

        $utils->printCities($citiesOrder);
        // echo PHP_EOL . self::$distance . PHP_EOL;
    }
}

$fileName = 'cities.txt';
$solve = new ShortestTour();
$solve->execute($fileName);
