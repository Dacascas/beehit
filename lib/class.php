<?php

class Storage
{
    public function __construct($filename)
    {
        $this->filename = __DIR__ . '/../cache/' . $filename;
    }

    public function store($bee_info)
    {
        $serialize_info = empty($bee_info) ? $bee_info : serialize($bee_info);
        file_put_contents($this->filename, $serialize_info);
    }

    public function get()
    {
        $serialize_info = file_get_contents($this->filename);
        $unserialize_info = unserialize($serialize_info);

        return $unserialize_info;
    }

    public function isEmpty()
    {
        $filesize = 0;
        if(file_exists($this->filename)) {
            $filesize = filesize($this->filename);
        }
        return !($filesize > 0);
    }
}

class BeeBuilder
{
    public $config;
    public $bee = [];

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function createBees()
    {
        foreach ($this->config as $bee_key => $bee) {
            for ($i = 1; $i <= $bee['count']; $i++) {
                $this->bee[$bee_key][]['health'] = $bee['health'];
            }
        }
    }

    public function getBee()
    {
        return $this->bee;
    }
}

class BeeHit
{
    private $bees = [];

    public function __construct(BeeBuilder $bees)
    {
        $this->bees = $bees;
    }

    public function hit($bee_hit)
    {
        list($bee_type, $bee_number) = explode(';', $bee_hit);

        $bee_health = $this->bees->bee[$bee_type][$bee_number]['health'];
        $bee_hit_deduction = $this->bees->config[$bee_type]['hit_deduction'];
        $bee_die_all = $this->bees->config[$bee_type]['die_all'];

        if($bee_health > $bee_hit_deduction) {
            $bee_health -= $bee_hit_deduction;
        } else {
            $bee_health = 0;

            if($bee_die_all) {
                $this->killAllBee();
            }
        }

        $this->bees->bee[$bee_type][$bee_number]['health'] = $bee_health;

        return $this->bees;
    }

    private function killAllBee()
    {
        foreach($this->bees->bee as $bees_key => $bees_value) {
            while (list($bee_key) = each($bees_value)) {
                $this->bees->bee[$bees_key][$bee_key]['health'] = 0;
            }
        }
    }
}

class Response
{
    private $bees;

    public function __construct(BeeBuilder $bees)
    {
        $this->bees = $bees;
    }

    public function __toString()
    {
        $html = '';

        include_once (__DIR__ . '/../template/bee.php');

        return $html;
    }

    public static function redirect($url)
    {
        header("Location: " . $url);
        die();
    }
}