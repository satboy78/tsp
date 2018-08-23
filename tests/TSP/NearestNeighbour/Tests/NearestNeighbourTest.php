<?php

namespace TSP\NearestNeighbour\Tests;

use TSP\NearestNeighbour\NearestNeighbour;

class NearestNeighbourTest extends \PHPUnit\Framework\TestCase
{
    use \TSP\Traits\InvokeMethods;

    /**
     * @param array $citiesList      cities list coming from dataProvider
     * @param array $distancesMatrix distances matrix coming from dataProvider
     * @param array $expectedResult  what we expect the shortest tour to be
     *
     * @dataProvider providerTestCreateTour
     */
    public function testCreateTour($citiesList, $distancesMatrix, $expectedResult)
    {
        $nearestNeighbour = new NearestNeighbour();
        $wrongResult = array('foo');

        $testResult = $nearestNeighbour->createTour($citiesList ? count($citiesList) : null, $distancesMatrix, $citiesList);

        $this->assertEquals($expectedResult, $testResult);
        $this->assertNotEquals($expectedResult, $wrongResult);
    }

    public function providerTestCreateTour()
    {
        $citiesList = array(
            array('Beijing', 39.93, 116.40),
            array('Tokyo', 35.40, 139.45),
            array('Singapore', 1.14, 103.55),
        );
        $distancesMatrix = array(
            array(25000.00, 2087.07, 4505.01),
            array(2087.07, 25000.00, 5316.53),
            array(4505.01, 5316.53, 25000.00),
        );
        $rightResult = array('Beijing', 'Tokyo', 'Singapore');

        return array(
            array($citiesList, $distancesMatrix, $rightResult),
            array(null, array(), array()),
            array(0, array(), array()),
        );
    }

    /**
     * @param array $distances      distances coming from dataProvider
     * @param float $expectedResult what we expect the city index to be
     *
     * @dataProvider providerTestSearchNearestCity
     */
    public function testSearchNearestCity($distances, $expectedResult)
    {
        $nearestNeighbour = new NearestNeighbour();
        $wrongResult = 20.00;

        $testResult = $this->invokeMethod($nearestNeighbour, 'searchNearestCity', array($distances));

        $this->assertEquals($expectedResult, $testResult);
        $this->assertNotEquals($expectedResult, $wrongResult);
    }

    public function providerTestSearchNearestCity()
    {
        return array(
            array(array(39.93, 116.40), 0),
            array(0, null),
            array(null, null),
        );
    }

    /**
     * @param array $array          distances coming from dataProvider
     * @param int   $key            the city I want to remove
     * @param int   $size           the $array
     * @param arrat $expectedResult what we expect the modified $array to be
     *
     * @dataProvider providerTestRemoveCity
     */
    public function testRemoveCity($array, $key, $size, $expectedResult)
    {
        $nearestNeighbour = new NearestNeighbour();
        $wrongResult = 20.00;

        $testResult = $this->invokeMethod($nearestNeighbour, 'removeCity', array($array, $key, $size));

        $this->assertEquals($expectedResult, $testResult);
        $this->assertNotEquals($expectedResult, $wrongResult);
    }

    public function providerTestRemoveCity()
    {
        return array(
            array(
                array(
                    array(25000.00, 39.00),
                    array(39.00, 25000.00),
                ),
                0,
                2,
                array(
                    array(25000.00, 25000.00),
                    array(25000.00, 25000.00),
                ),
            ),
            array(array(), 0, null, null),
            array(null, null, null, null),
        );
    }
}
