<?php
require 'app/models/SubjectAreas.php';
require 'app/models/Subject.php';

class SubjectAreasTest extends PHPUnit_Framework_TestCase {
    public function setUp() {
        $this->subjectAreas = new SubjectAreas();
    }

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
        $this->assertCount(0, $this->subjectAreas->getAreas());
    }

    public function testGetAreaReturnsAreas() {
        $subject = $this->createSubject("subject");
        $subjectArea = $this->createArea($subject->id, $subject->id);

        $this->assertCount(1, $this->subjectAreas->getAreas());
    }

    public function testGetSubjectsByAreaEmpty() {
        $this->assertCount(0, $this->subjectAreas->getSubjectsByArea(1));
    }

    public function testGetSubjectsByAreaReturnsOneSubject() {
        $subject = $this->createSubject("subject");
        $subjectArea = $this->createArea($subject->id, $subject->id);

        $this->assertCount(1,
            $this->subjectAreas->getSubjectsByArea($subjectArea->subjectId));
    }

    public function testGetSubjectsByAreaReturnsTwoSubjects() {
        $subject = $this->createSubject("subject one");
        $subjectTwo = $this->createSubject("subject two");
        $subjectArea = $this->createArea($subject->id, $subject->id);
        $subjectAreaTwo = $this->createArea($subjectTwo->id, $subject->id);

        $this->assertCount(2,
            $this->subjectAreas->getSubjectsByArea($subject->id));
    }

    public function testGetSubjectsGroupedJson() {
        $this->assertEmpty($this->subjectAreas->getSubjectsGrouped());
    }

    public function testGetSubjectsGroupedReturnsAreaAndSubject() {
        $area = $this->createSubject("Test Area");
        $subject = $this->createSubject("subject one");
        $subjectArea = $this->createArea($subject->id, $area->id);

        $expectedOptions = array();
        $expectedOption = array("area" => $area->name,
            "subjects" => $this->subjectAreas
                            ->getSubjectsByArea($area->id)->toArray());

        $freeSubjects = array("area" => "free",
            "subjects" => $this->subjectAreas->getFreeSubjects());

        $expectedOptions []= $expectedOption;
        $expectedOptions []= $freeSubjects;

        $groups = $this->subjectAreas->getSubjectsGrouped();
        $options = $groups[0];

        $this->assertEquals($expectedOption["area"], $options["area"]);
        $this->assertEquals($expectedOption["subjects"], $options["subjects"]);
    }

    public function testGetSubjectsGroupedReturnsFreeSubjects() {
        $subject = $this->createSubject("subject one");
        $groups = $this->subjectAreas->getSubjectsGrouped();
        $groupFree = $groups[0];

        $this->assertEquals("free", $groupFree["area"]);
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