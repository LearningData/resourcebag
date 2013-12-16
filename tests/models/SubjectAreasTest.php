<?php
require 'app/models/SubjectAreas.php';
require 'app/models/Subject.php';

class SubjectAreasTest extends PHPUnit_Framework_TestCase {
    public function tearDown() {
        Subject::find()->delete();
        SubjectAreas::find()->delete();
    }

    public function testColumnMap() {
        $columns = SubjectAreas::columnMap();
        $this->assertEquals("id", $columns["id"]);
        $this->assertEquals("subjectId", $columns["subjectId"]);
        $this->assertEquals("areaId", $columns["areaId"]);
        $this->assertEquals("cohortId", $columns["cohortId"]);
        $this->assertEquals("schoolId", $columns["schoolId"]);
    }

    public function testGetFreeSubjectsReturnsEmptyArray() {
        $this->assertEquals(array(), SubjectAreas::getFreeSubjects());
    }

    public function testGetFreeSubjectsNotReturnsSubjectsWithArea() {
        $subject = $this->createSubject("subject");
        $subjectArea = $this->createArea($subject->id);

        $this->assertEquals(array(), SubjectAreas::getFreeSubjects());
    }

    public function testGetFreeSubjectsReturnsSubjects() {
        $subject = new Subject();
        $subject->name = "test";
        $subject->save();

        $this->assertCount(1, SubjectAreas::getFreeSubjects());
    }

    public function testGetFreeSubjectsReturnsJustFreeSubjects() {
        $subject = $this->createSubject("subject");
        $subjectArea = $this->createArea($subject->id);
        $subjectFree = $this->createSubject("Free Subject");

        $this->assertCount(1, SubjectAreas::getFreeSubjects());
        $subjects = SubjectAreas::getFreeSubjects();

        $this->assertEquals($subjectFree->name, $subjects[0]->name);
    }

    public function testGetAreaEmpty() {
        $subjectAreas = new SubjectAreas();
        $this->assertCount(0, $subjectAreas->getAreas());
    }

    public function testGetAreaReturnsAreas() {
        $subjectAreas = new SubjectAreas();
        $subject = $this->createSubject("subject");
        $subjectArea = $this->createArea($subject->id, $subject->id);

        $this->assertCount(1, $subjectAreas->getAreas());
    }

    public function testGetSubjectsByAreaEmpty() {
        $subjectAreas = new SubjectAreas();
        $this->assertCount(0, $subjectAreas->getSubjectsByArea(1));
    }

    public function testGetSubjectsByAreaReturnsOneSubject() {
        $subjectAreas = new SubjectAreas();
        $subject = $this->createSubject("subject");
        $subjectArea = $this->createArea($subject->id, $subject->id);
        $this->assertCount(1,
            $subjectAreas->getSubjectsByArea($subjectArea->subjectId));
    }

    public function testGetSubjectsByAreaReturnsTwoSubjects() {
        $subjectAreas = new SubjectAreas();
        $subject = $this->createSubject("subject one");
        $subjectTwo = $this->createSubject("subject two");
        $subjectArea = $this->createArea($subject->id, $subject->id);
        $subjectAreaTwo = $this->createArea($subjectTwo->id, $subject->id);
        $this->assertCount(2,
            $subjectAreas->getSubjectsByArea($subject->id));
    }

    private function createSubject($name) {
        $subject = new Subject();
        $subject->name = $name;
        $subject->save();

        return $subject;
    }

    private function createArea($subjectId, $areaId=1) {
        $subjectArea = new SubjectAreas();
        $subjectArea->subjectId = $subjectId;
        $subjectArea->areaId = $areaId;
        $subjectArea->schoolId = 1;
        $subjectArea->cohortId = 1;

        $subjectArea->save();

        return $subjectArea;
    }
}