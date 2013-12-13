<?php
require 'app/services/HomeworkService.php';
require 'app/models/ClassList.php';

class HomerworkServiceTest extends PHPUnit_Framework_TestCase {
    public function setUp() {
        $this->classList = $this->getClassList();
        $this->user = new User();
        $this->user->id = 1;
        $this->user->schoolId = 1;
        $this->params = array(
            "description" => "test description",
            "due-date" => "2013-09-10",
            "title" => "test title",
            "due-time" => "0900"
        );

        $this->homework = HomeworkService::create($this->classList,
            $this->params, $this->user->id);

        $this->homeworkUser = HomeworkService::createHomeworkUser(1,
            $this->user->id);
    }
    public function testCreateHomeworkNotNull() {
        $this->assertNotNull($this->homework);
    }

    public function testCreateHomeworkAttributes() {
        $this->assertEquals(
            $this->params["description"],
            $this->homework->text
        );

        $this->assertEquals(
            $this->params["title"],
            $this->homework->title
        );

        $this->assertEquals(
            $this->params["due-date"],
            $this->homework->dueDate
        );

        $this->assertEquals(
            $this->params["due-time"],
            $this->homework->timeSlotId
        );

        $this->assertEquals(
            Homework::$PENDING,
            $this->homeworkUser->status
        );

        $this->assertEquals(
            $this->classList->id,
            $this->homework->classId
        );

        $this->assertEquals(
            $this->classList->user->id,
            $this->homework->teacherId
        );

        $this->assertEquals(
            $this->user->id,
            $this->homeworkUser->studentId
        );

        $this->assertEquals(
            $this->user->schoolId,
            $this->homework->schoolId
        );
    }

    private function getClassList() {
        $classList = new ClassStub();
        $classList->id = 1;
        $classList->schoolId = 1;
        $classList->user = new User();
        $classList->user->id = 2;

        return $classList;
    }
}

class ClassStub {
    public $id;
    public $user;
    public $schoolId;
}
?>