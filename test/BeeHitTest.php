<?php

/**
 * Created by PhpStorm.
 * User: Dacascas
 * Date: 02/02/2016
 * Time: 12:22
 */

require_once __DIR__ . '/../lib/class.php';

class BeeHitTest extends PHPUnit_Framework_TestCase
{
    protected $beehit;
    protected $config;

    /**
     * BeeHitTest constructor.
     * @var $bees BeeBuilder
     */
    public function __construct()
    {
        $config = [];
        require __DIR__ . '/../lib/conf.php';
        $this->config = $config;
        $bees = new BeeBuilder($this->config);
        $bees->createBees();
        $this->beehit = new BeeHit($bees);
    }

    public function testIfWeRealHitQueenBee()
    {
        $hitbee = 'Queen;0';

        $hittedBee = $this->beehit->hit($hitbee);

        $healthAfterDeduction = $this->config['Queen']['health'] - $this->config['Queen']['hit_deduction'];

        $this->assertEquals($hittedBee->bee['Queen'][0]['health'], $healthAfterDeduction, 'We hit the Queen');
    }

    public function testIfWeRealHitWorkersBee()
    {
        $hitbee = 'Workers;0';

        $hittedBee = $this->beehit->hit($hitbee);

        $healthAfterDeduction = $this->config['Workers']['health'] - $this->config['Workers']['hit_deduction'];

        $this->assertEquals($hittedBee->bee['Workers'][0]['health'], $healthAfterDeduction, 'We hit the worker');
    }

    public function testIfWeRealHitDroneBee()
    {
        $hitbee = 'Drone;0';

        $hittedBee = $this->beehit->hit($hitbee);

        $healthAfterDeduction = $this->config['Drone']['health'] - $this->config['Drone']['hit_deduction'];

        $this->assertEquals($hittedBee->bee['Drone'][0]['health'], $healthAfterDeduction, 'We hit the drone');
    }

    public function testIfWeRealKillAllBeeIfKillQueen()
    {
        $this->assertEquals(true, $this->config['Queen']['die_all'], 'Queen can to kill all bee');

        $count = ceil($this->config['Queen']['health'] / $this->config['Queen']['hit_deduction']);

        $killedAllBee = [];

        for($i = 0; $i <=$count; $i++) {
            $killedAllBee = $this->beehit->hit('Queen;0');
        }

        $healthAfterKill = 0;

        foreach($killedAllBee->bee as $name => $bees) {
            foreach($bees as $key => $bee) {
                $healthAfterKill += $bee['health'];
            }
        }

        $this->assertEquals(0, $healthAfterKill, 'Queen dont kill all bee');
    }
}
