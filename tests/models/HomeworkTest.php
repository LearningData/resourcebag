<?php
require 'app/models/Homework.php';

class HomeworkTest extends PHPUnit_Framework_TestCase {
    public function setUp() {
        $this->homework = new Homework();
        $this->homework->status = Homework::$PENDING;
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

    public function testIsReviewedFalse() {
        $this->assertFalse($this->homework->isReviewed());
    }

    public function testIsReviewed() {
        $this->homework->status = Homework::$REVIEWED;
        $this->assertTrue($this->homework->isReviewed());
    }

    public function testIsPendingFalse() {
        $this->homework->status = Homework::$REVIEWED;
        $this->assertFalse($this->homework->isPending());
    }

    public function testIsPending() {
        $this->assertTrue($this->homework->isPending());
    }

    public function testIsSubmittedFalse() {
        $this->assertFalse($this->homework->isSubmitted());
    }

    public function testIsSubmitted() {
        $this->homework->status = Homework::$SUBMITTED;
        $this->assertTrue($this->homework->isSubmitted());
    }
}
?>