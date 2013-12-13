<?php
require 'app/models/Homework.php';

class HomeworkTest extends PHPUnit_Framework_TestCase {
    public function setUp() {
        $this->homework = new Homework();
    }

    public function testStatusPending() {
        $this->assertEquals(0, Homework::$PENDING);
    }

    public function testStatusStarted() {
        $this->assertEquals(1, Homework::$STARTED);
    }

    public function testStatusSubmitted() {
        $this->assertEquals(2, Homework::$SUBMITTED);
    }

    public function testStatusReviewed() {
        $this->assertEquals(3, Homework::$REVIEWED);
    }
}
?>