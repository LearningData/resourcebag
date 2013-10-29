<?php
require 'app/models/Config.php';

class ConfigTest extends PHPUnit_Framework_TestCase {
    public function setUp() {
        $this->config = new Config();
        $this->config->name = "schoolYear";
        $this->year = "2013";
    }

    public function testWithoutSchoolYear() {
        $this->assertEquals(date("Y"), Config::schoolYear());
    }

    public function testReturnsYearFromDatabase() {
        $this->config->save();
        $this->assertEquals($this->year, Config::schoolYear());
        $this->config->delete();
    }
}

?>