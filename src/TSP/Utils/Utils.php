<?php

namespace TSP\Utils;

class Utils
{
    // M_PI / 180
    const RAD = 0.0174;
    // 1.609344 is the number of kilometres in a mile; 60 is the number of minutes in a degree; 1.1515 is the number of statute miles in a nautical mile
    // 60 * 1.609344 * 1.1515
    const MULTIPLIER = 111.19;
    // a distance that is bigger than the longest possible trip from A to B on earth
    const IMPOSSIBLE_DISTANCE = 25000.00;

    /**
     * Open file and extracts data.
     *
     * @param string $fileName name of the file we want to parse
     *
     * @return array|bool list of cities and their GPS coordinates, or false
     */
    public function getCities($fileName)
    {
        $citiesList = array();
        if ($fileName) {
            $handle = fopen($fileName, 'r');

            if (!$handle) {
                return false;
            }

            while (($line = fgets($handle)) !== false) {
                $line = trim($line);
                //  read until reaching an empty line
                if ($line != '') {
                    $citiesList[] = explode("\t", $line);
                }
            }

            fclose($handle);
        }

        return $citiesList;
    }

    /**
     * Print the ordered list of cities.
     *
     * @param array $citiesOrdered list of cities
     */
    public function printCities($citiesOrdered)
    {
        if (!is_array($citiesOrdered)) {
            return;
        }

        $printCity = function ($city) {
            echo $city.PHP_EOL;
        };

        array_walk($citiesOrdered, $printCity);
    }

    /**
     * Calculate the distance from A to B on earth, given their coordinates
     * https://stackoverflow.com/questions/10053358/measuring-the-distance-between-two-coordinates-in-php.
     *
     * @param float $latitudeFrom  latitude of point A
     * @param float $longitudeFrom longitude of point A
     * @param float $latitudeTo    latitude of point B
     * @param float $longitudeTo   longitude of point B
     *
     * @return float distance from A to B
     */
    private function getDistance($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo)
    {
        if (!$latitudeFrom || !$longitudeFrom || !$latitudeTo || !$longitudeTo) {
            return 0;
        }

        //Calculate distance from latitude and longitude, in KM
        $theta = (float) $longitudeFrom - (float) $longitudeTo;
        $dist = sin((float) $latitudeFrom * self::RAD) * sin((float) $latitudeTo * self::RAD) + cos((float) $latitudeFrom * self::RAD) * cos((float) $latitudeTo * self::RAD) * cos($theta * self::RAD);

        return round((acos($dist) / self::RAD * self::MULTIPLIER), 2);
    }

    /**
     * Generate a matrix of distances between given cities.
     * The distance between two cities is the same in each opposite direction
     * (a --> b === b --> a); this means I can calculate the distance of only
     * half the matrix, the other half can be mirrored on the diagonal.
     *
     * @param array $citiesList list of cities and their GPS coordinates
     * @param int   $arrLength  size of cities list
     *
     * @return array matrix of distances between cities
     */
    public function calculateDistances($citiesList, $arrLength)
    {
        $distancesMatrix = array();
        if (!is_array($citiesList)) {
            return $distancesMatrix;
        } elseif (count($citiesList) === 0) {
            return $distancesMatrix;
        }

        for ($i = 0; $i < $arrLength; ++$i) {
            $distancesMatrix[$i][$i] = self::IMPOSSIBLE_DISTANCE;
            for ($j = $i + 1; $j < $arrLength; ++$j) {
                $distancesMatrix[$i][$j] = $distancesMatrix[$j][$i] = $this->getDistance($citiesList[$i][1], $citiesList[$i][2], $citiesList[$j][1], $citiesList[$j][2]);
            }
        }

        return $distancesMatrix;
    }
}
