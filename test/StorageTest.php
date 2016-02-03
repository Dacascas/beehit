<?php

/**
 * Created by PhpStorm.
 * User: Dacascas
 * Date: 02/02/2016
 * Time: 12:23
 */
include_once __DIR__ . '/../lib/class.php';

class StorageTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Storage
     */
    protected $storage;
    protected $filename = 'testbee.txt';
    protected $storeArray = ['1', '2'];

    public function __construct()
    {
        $this->storage = new Storage($this->filename);
        $this->fullpath = __DIR__  . '/../cache/' . $this->filename;
    }

    public function testIfFileNotExist()
    {
        $emptyFile = $this->storage->isEmpty();

        $this->assertEquals(True, $emptyFile, 'Dont exist file form method');
        $this->assertFileNotExists($this->fullpath, 'File real not exist');
    }

    /**
     * @depends testIfFileNotExist
     */
    public function testFileCreateAndSaveData()
    {
        $this->storage->store($this->storeArray);
        $this->assertFileExists($this->fullpath, 'File exist already');

        $testString = serialize($this->storeArray);

        $this->assertStringEqualsFile($this->fullpath, $testString, 'Equals string which we set and what we create by hand');
    }

    /**
     * @depends testFileCreateAndSaveData
     */
    public function testGetStringFromFile()
    {
        $storeArray = $this->storage->get();

        $this->assertEquals($this->storeArray, $storeArray, 'We can get info from file');
    }

    public function testIfFileExist()
    {
        $emptyFile = $this->storage->isEmpty();

        $this->assertEquals(False, $emptyFile, 'Test if file still exist');
    }

    public function testIfFileDelete()
    {
        unlink($this->fullpath);

        $this->assertFileNotExists($this->fullpath, 'Test pass and file was deleted');
    }
}
