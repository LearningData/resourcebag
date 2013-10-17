<?php
require 'app/services/FileService.php';

class FileServiceTest extends PHPUnit_Framework_TestCase {
    public function setUp() {
        $this->dir = "/tmp/test_files_schoolbag/";
        $this->fileName = "test_schoolbag_file.txt";
        mkdir($this->dir);
    }

    public function tearDown() {
        rmdir($this->dir);
    }

    public function testReturnsEmptyArray() {
        $this->assertEquals(array(), FileService::listFiles($this->dir));
    }

    public function testReturnsArrayWithFilesNames() {
        $this->makeFile($this->dir . $this->fileName);
        $this->assertEquals(array($this->fileName), FileService::listFiles($this->dir));
        unlink($this->dir . $this->fileName);
    }

    public function testNotReturnsHiddenFiles() {
        $hidden_file = $this->dir . "." . $this->fileName;
        $this->makeFile($hidden_file);
        $this->assertEquals(array(), FileService::listFiles($this->dir));
        unlink($hidden_file);
    }

    public function testListFilesNamesWithoutHiddenFiles() {
        $hidden_file = $this->dir . "." . $this->fileName;
        $file = $this->dir . $this->fileName;

        $this->makeFile($hidden_file);
        $this->makeFile($file);

        $this->assertEquals(array($this->fileName), FileService::listFiles($this->dir));
        unlink($hidden_file);
        unlink($file);
    }

    private function makeFile($path) {
        $file = fopen($path, "w");
        fclose($file);
    }
}