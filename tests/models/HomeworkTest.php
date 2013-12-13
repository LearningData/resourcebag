<?php
require 'app/models/Homework.php';
require 'app/models/HomeworkUser.php';

class HomeworkTest extends PHPUnit_Framework_TestCase {
    public function setUp() {
        $this->homework = new Homework();
        $this->homeworkUser = new HomeworkUser();
        $this->homeworkUser->status = Homework::$PENDING;
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
        $this->assertFalse($this->homeworkUser->isReviewed());
    }

    public function testIsReviewed() {
        $this->homeworkUser->status = Homework::$REVIEWED;
        $this->assertTrue($this->homeworkUser->isReviewed());
    }

    public function testIsPendingFalse() {
        $this->homeworkUser->status = Homework::$REVIEWED;
        $this->assertFalse($this->homeworkUser->isPending());
    }

    public function testIsPending() {
        $this->assertTrue($this->homeworkUser->isPending());
    }

    public function testIsSubmittedFalse() {
        $this->assertFalse($this->homeworkUser->isSubmitted());
    }

    public function testIsSubmitted() {
        $this->homeworkUser->status = Homework::$SUBMITTED;
        $this->assertTrue($this->homeworkUser->isSubmitted());
    }
}
?>