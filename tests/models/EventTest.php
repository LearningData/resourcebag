<?php
require 'app/models/Event.php';

class EventTest extends PHPUnit_Framework_TestCase {
    public function setUp() {
        $this->event = new Event();
    }

    public function testDontAddHttpOnUrl() {
        $link = "http://www.test.com";
        $this->event->link = $link;
        $this->event->beforeSave();
        $this->assertEquals($link, $this->event->link);
    }

    public function testAddHttpOnUrl() {
        $link = "www.test.com";
        $this->event->link = $link;
        $this->event->beforeSave();
        $this->assertEquals("http://" . $link, $this->event->link);
    }

    public function testNotAddHttpsOnUrl() {
        $link = "https://www.test.com";
        $this->event->link = $link;
        $this->event->beforeSave();
        $this->assertEquals($link, $this->event->link);
    }

    public function testFixUrlAndSave() {
        $link = "www.test.com";
        $this->event->link = $link;
        $this->event->title = "test";
        $this->event->start = date("Y-m-d");
        $this->event->end = date("Y-m-d");
        $this->event->createdAt = date("Y-m-d");
        $this->event->userId = 1;
        $this->event->id = 1;

        $this->event->save();
        $this->assertEquals("http://" . $link, $this->event->link);
        $this->event->delete();
    }
}
?>