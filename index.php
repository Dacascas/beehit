<?php
/**
 * Created by PhpStorm.
 * User: Dacascas
 * Date: 31/01/2016
 * Time: 22:56
 */

include_once 'lib/conf.php';
include_once 'lib/class.php';

$storage = new Storage('bee.txt');

if(isset($_REQUEST['reset'])) {
    $storage->store('');
    Response::redirect('/');
}

if($storage->isEmpty()) {
    $bees = (new BeeBuilder($config))->createBees();
    $storage->store($bees);
} else {
    $bees = $storage->get();
}

if(isset($_REQUEST['bee'])) {
    $bees = (new BeeHit($bees))->hit($_REQUEST['bee']);
    $storage->store($bees);
}

echo new Response($bees);