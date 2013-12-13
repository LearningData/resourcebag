<?php
require 'app/models/Homework.php';

class HomeworkTest extends PHPUnit_Framework_TestCase {
    public function setUp() {
        $this->homework = new Homework();
        $this->homework->dueDate = "2013-12-16";
        $this->homework->setDate = "2013-12-13";
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

    public function testGetDueDateDefault() {
        $this->assertEquals("Mon 16th Dec 2013",
            $this->homework->getDueDate());
    }

    public function testGetDueDateWithFormat() {
        $this->assertEquals("2013/12/16",
            $this->homework->getDueDate("Y/m/d"));
    }

    public function testColumnMap() {
        $columns = $this->homework->columnMap();

        $this->assertEquals("id", $columns["homeworkID"]);
        $this->assertEquals("schoolId", $columns["schoolID"]);
        $this->assertEquals("teacherId", $columns["teacherID"]);
        $this->assertEquals("classId", $columns["classID"]);
        $this->assertEquals("timeSlotId", $columns["timeslotID"]);
        $this->assertEquals("setDate", $columns["setDate"]);
        $this->assertEquals("dueDate", $columns["dueDate"]);
        $this->assertEquals("text", $columns["text"]);
        $this->assertEquals("owner", $columns["owner"]);
    }

    public function testGetSetDateDefault() {
        $this->assertEquals("Fri 13th Dec 2013",
            $this->homework->getSetDate());
    }

    public function testGetSetDateWithFormat() {
        $this->assertEquals("2013/12/13",
            $this->homework->getSetDate("Y/m/d"));
    }
}
?>