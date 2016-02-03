<?php

/**
 * Created by PhpStorm.
 * User: Dacascas
 * Date: 02/02/2016
 * Time: 12:21
 */

require_once __DIR__ . '/../lib/class.php';

class BeeBuilderTest extends PHPUnit_Framework_TestCase
{
    protected $bees;
    protected $config;

    public function __construct()
    {
        $config = [];
        require __DIR__ . '/../lib/conf.php';
        $this->config = $config;
        $this->bees = new BeeBuilder($config);
        $this->bees->createBees();
    }

    public function testBuildClassFromConfig()
    {
        foreach($this->bees->bee as $name => $value) {
            $this->assertArrayHasKey($name, $this->config, 'Equals name of sets');
            $this->assertEquals($value[0]['health'], $this->config[$name]['health'], 'Equals health');
        }
    }

    public function testGetBee()
    {
        $bees = $this->bees->getBee();
        $this->assertEquals($bees, $this->bees->bee, 'We response appropriate info');
    }
}
