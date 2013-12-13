<?php
require 'app/models/HomeworkUser.php';

class HomeworkUserTest extends PHPUnit_Framework_TestCase {
    public function setUp() {
        $this->homeworkUser = new HomeworkUser();
        $this->homeworkUser->status = Homework::$PENDING;
        $this->homeworkUser->submittedDate = "2013-12-13";
        $this->homeworkUser->reviewedDate = "2013-12-16";
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

    public function testGetSubmittedDateDefault() {
        $this->assertEquals($this->homeworkUser->getSubmittedDate(),
            "Fri 13th Dec 2013");
    }

    public function testGetSubmittedDateWithFormat() {
        $this->assertEquals($this->homeworkUser->getSubmittedDate("Y/m/d"),
            "2013/12/13");
    }

    public function testGetReviewedDateDefault() {
        $this->assertEquals($this->homeworkUser->getReviewedDate(),
            "Mon 16th Dec 2013");
    }

    public function testGetReviewedDateWithFormat() {
        $this->assertEquals($this->homeworkUser->getReviewedDate("Y/m/d"),
            "2013/12/16");
    }

    public function testGetStatusReviewed() {
        $this->homeworkUser->status = Homework::$REVIEWED;
        $this->assertEquals("reviewed", $this->homeworkUser->getStatus());

    }

    public function testGetStatusSubmitted() {
        $this->homeworkUser->status = Homework::$SUBMITTED;
        $this->assertEquals("submitted", $this->homeworkUser->getStatus());
    }

    public function testGetStatusPending() {
        $this->homeworkUser->status = Homework::$PENDING;
        $this->assertEquals("pending", $this->homeworkUser->getStatus());
    }

    public function testGetStatusStarted() {
        $this->homeworkUser->status = Homework::$STARTED;
        $this->assertEquals("pending", $this->homeworkUser->getStatus());
    }
}
?>