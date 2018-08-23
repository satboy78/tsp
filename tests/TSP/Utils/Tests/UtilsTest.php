<?php

namespace TSP\Utils\Tests;

use TSP\Utils\Utils;

class UtilsTest extends \PHPUnit\Framework\TestCase
{
    use \TSP\Traits\InvokeMethods;

    /**
     * @param array $citiesList     cities list coming from dataProvider
     * @param array $expectedResult what we expect the distances matrix to be
     *
     * @dataProvider providerTestCalculateDistances
     */
    public function testCalculateDistances($citiesList, $expectedResult)
    {
        $utils = new Utils();
        $wrongResult = array(array(0, 0, 0), array(0, 0, 0), array(0, 0, 0));

        $testResult = $utils->calculateDistances($citiesList, $citiesList ? count($citiesList) : null);

        $this->assertEquals($expectedResult, $testResult);
        $this->assertNotEquals($expectedResult, $wrongResult);
    }

    public function providerTestCalculateDistances()
    {
        $citiesList = array(
            array('Beijing', 39.93, 116.40),
            array('Tokyo', 35.40, 139.45),
            array('Singapore', 1.14, 103.55),
        );
        $rightResult = array(
            array(25000.00, 2087.07, 4505.01),
            array(2087.07, 25000.00, 5316.53),
            array(4505.01, 5316.53, 25000.00),
        );

        return array(
            array($citiesList, $rightResult),
            array(null, array()),
            array(array(), array()),
        );
    }

    /**
     * @param array $coordinates    coordinates coming from dataProvider
     * @param float $expectedResult what we expect the distance result to be
     *
     * @dataProvider providerTestGetDistance
     */
    public function testGetDistance($coordinates, $expectedResult)
    {
        $utils = new Utils();
        $wrongResult = 20.00;

        $testResult = $this->invokeMethod(
            $utils,
            'getDistance',
            array($coordinates[0][0], $coordinates[0][1], $coordinates[1][0], $coordinates[1][1])
        );

        $this->assertEquals($expectedResult, $testResult);
        $this->assertNotEquals($expectedResult, $wrongResult);
    }

    public function providerTestGetDistance()
    {
        $beijing = array(39.93, 116.40);
        $tokio = array(35.40, 139.45);
        $rightResult = 2087.07;

        return array(
            array(array($beijing, $tokio), $rightResult),
            array(array($beijing, $beijing), 0),
            array(array(array(null, null), array(null, null)), 0),
            array(array(array(null, null), null), 0),
            array(array(null, array(null, null)), 0),
            array(array(null, null), 0),
        );
    }

    /**
     * @param array $filename       filename coming from dataProvider
     * @param array $expectedResult what we expect the distances matrix to be
     *
     * @dataProvider providerTestGetCities
     */
    public function testGetCities($filename, $expectedResult)
    {
        $utils = new Utils();
        $wrongResult = array('foo');

        $testResult = $utils->getCities($filename);

        $this->assertEquals($expectedResult, $testResult);
        $this->assertNotEquals($expectedResult, $wrongResult);
    }

    public function providerTestGetCities()
    {
        $cities = array(array('Beijing', 39.93, 116.40), array('Tokyo', 35.40, 139.45));
        $citiesNoTab = array(array('Beijing'), array('Tokio'));

        return array(
            array('tests/cities.txt', $cities),
            array('tests/citiesNoTab.txt', $citiesNoTab),
            array('tests/empty.txt', array()),
            array(null, array()),
        );
    }
}
