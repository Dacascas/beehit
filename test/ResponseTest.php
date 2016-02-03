<?php

/**
 * Created by PhpStorm.
 * User: Dacascas
 * Date: 02/02/2016
 * Time: 12:23
 */

require_once __DIR__ . '/../lib/class.php';

class ResponseTest extends PHPUnit_Framework_TestCase
{
    protected $response;

    public function __construct()
    {
        $config = [];
        require __DIR__ . '/../lib/conf.php';
        $bees = new BeeBuilder($config);
        $bees->createBees();
        $this->response = new Response($bees);
    }

    public function testHtmlResponse()
    {
        ob_start();
        echo $this->response;
        $html = ob_get_contents();
        ob_end_clean();

        $this->assertGreaterThan(100, strlen($html), 'Response has some html code');
    }
}