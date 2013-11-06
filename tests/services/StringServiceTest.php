<?php
require 'app/services/StringService.php';

class StringServiceTest extends PHPUnit_Framework_TestCase {
    public function testStartWithReturnsTrue() {
        $this->assertTrue(StringService::startsWith("en-us", "en"));
    }

    public function testStartWithReturnsFalse() {
        $this->assertFalse(StringService::startsWith("en-us", "pt"));
    }

    public function testStartWithReturnsFalseWithNullValues() {
        $this->assertFalse(StringService::startsWith(null, "pt"));
        $this->assertFalse(StringService::startsWith("en-us", null));
        $this->assertFalse(StringService::startsWith(null, null));
    }

    public function testStartWithReturnsFalseWithEmptyValues() {
        $this->assertFalse(StringService::startsWith("", "pt"));
        $this->assertFalse(StringService::startsWith("en-us", ""));
        $this->assertFalse(StringService::startsWith("", ""));
    }
}