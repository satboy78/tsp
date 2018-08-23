<?php

namespace TSP\NearestNeighbour;

class NearestNeighbour
{
    // a distance that is bigger than the longest possible trip from A to B on earth
    const IMPOSSIBLE_DISTANCE = 25000.00;
    private $distance = 0;

    /**
     * Get nearest city index in the array.
     *
     * @param array $distances distances of all cities from the selected one
     *
     * @return int|null nearest city index in the array, or null
     */
    private function searchNearestCity($distances)
    {
        if (!is_array($distances)) {
            return null;
        } elseif (count($distances) === 0) {
            return null;
        }

        $minDistance = min($distances);
        $nearestCityIndex = array_keys($distances, $minDistance);

        return reset($nearestCityIndex);
    }

    /**
     * Mark as invalid the selected city at the index $key
     * In order to exclude the selected city from the possible results
     * in the next iterations I set its distance from other cities bigger
     * than the longest possible trip from A to B on earth.
     *
     * @param array $array matrix of distances between cities
     * @param int   $key   index if the city we want ro remove
     * @param int   $size  size of the array
     *
     * @return array|null modified matrix, or null
     */
    private function removeCity($array, $key, $size)
    {
        if (!is_array($array)) {
            return null;
        } elseif (count($array) === 0) {
            return null;
        }

        for ($i = 0; $i < $size; ++$i) {
            $array[$i][$key] = $array[$key][$i] = self::IMPOSSIBLE_DISTANCE;
        }

        return $array;
    }

    /**
     * Actual implementation of NearestNeighbour algorithm.
     *
     * @param int   $arrLength       size of cities list
     * @param array $distancesMatrix matrix of distances between cities
     * @param array $citiesList      list of cities we want to parse
     *
     * @return array ordered list of cities
     */
    public function createTour($arrLength, $distancesMatrix, $citiesList)
    {
        $citiesOrder = array();

        if (!isset($arrLength) || $arrLength <= 0) {
            return $citiesOrder;
        }

        // start of the route is the first city of the list provided in the file
        $index = 0;
        $citiesOrder[] = $citiesList[$index][0];

        // make it recursive
        for ($i = 0; $i < $arrLength - 1; ++$i) {
            // extract distances from current city, at position $index
            $distances = array_column($distancesMatrix, $index);
            // search the nearest city from the current one
            $newCityIndex = $this->searchNearestCity($distances);
            // get total distance
            $this->distance += $distances[$newCityIndex];
            // append the city we found in the final list
            $citiesOrder[] = $citiesList[$newCityIndex][0];
            // invalidate the first city - $index - in the matrix, so it will not show up again in results
            $distancesMatrix = $this->removeCity($distancesMatrix, $index, $arrLength);
            // use $newCityIndex for the next iteration
            $index = $newCityIndex;
        }
        // echo PHP_EOL . $this->distance . PHP_EOL;
        return $citiesOrder;
    }
}
