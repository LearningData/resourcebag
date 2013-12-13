<?php
require 'app/services/HomeworkService.php';
require 'app/models/ClassList.php';
require 'app/models/HomeworkFile.php';

use Phalcon\Http\Request\File;

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

        $this->fileName = "/tmp/test_file.txt";
        $file = fopen($this->fileName, 'w');
        fclose($file);
    }

    public function tearDown() {
        unlink($this->fileName);
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

    public function testGetPaginateLinksSize() {
        $links = HomeworkService::getPaginateLinks("test", 2, 0);
        $this->assertEquals(2, count($links));
    }

    public function testGetPaginateLinksContent() {
        $status = 0;
        $links = HomeworkService::getPaginateLinks("test", 2, $status);
        $page = 1;

        foreach($links as $link) {
            $this->assertEquals("test/homework?page=$page&filter=$status",
                $link["url"]);
            $this->assertEquals($page, $link["page"]);
            $page++;
        }
    }

    public function testGetLinksByClassSize() {
        $links = HomeworkService::getLinksByClass("test", 1, 2, 0);
        $this->assertEquals(2, count($links));
    }

    public function testGetLinksByClassContent() {
        $status = 0;
        $classId = 1;
        $links = HomeworkService::getLinksByClass("test", $classId, 2, $status);
        $page = 1;

        foreach($links as $link) {
            $this->assertEquals("test/homework/class/$classId?page=$page&filter=$status",
                $link["url"]);
            $this->assertEquals($page, $link["page"]);
            $page++;
        }
    }

    public function testCreateFile() {
        $file = $this->getFile();

        $homeworkId = 1;
        $description = "test decription";

        $homeworkFile = HomeworkService::createFile($homeworkId, $file,
            $description);

        $this->assertInstanceOf('HomeworkFile', $homeworkFile);
    }

    public function testCreateFileGetName() {
        $file = $this->getFile();
        $file->expects($this->any())
             ->method('getName')
             ->will($this->returnValue("test_name"));

        $homeworkFile = HomeworkService::createFile(1, $file, "description");

        $this->assertEquals("test_name", $homeworkFile->name);
    }

    public function testCreateFileGetDescription() {
        $file = $this->getFile();
        $homeworkFile = HomeworkService::createFile(1, $file, "description");

        $this->assertEquals("description", $homeworkFile->description);
    }

    public function testCreateFileGetType() {
        $file = $this->getFile();
        $file->expects($this->any())
             ->method('getType')
             ->will($this->returnValue("txt"));
        $homeworkFile = HomeworkService::createFile(1, $file, "description");

        $this->assertEquals("txt", $homeworkFile->type);
    }

    private function getClassList() {
        $classList = new ClassStub();
        $classList->id = 1;
        $classList->schoolId = 1;
        $classList->user = new User();
        $classList->user->id = 2;

        return $classList;
    }

    private function getFile() {
        $mockFile = $this->getMock('File', array("getName",
            "getSize", "getType", "getTempName"));

        $mockFile->expects($this->any())
             ->method('getTempName')
             ->will($this->returnValue($this->fileName));

        return $mockFile;
    }
}

class ClassStub {
    public $id;
    public $user;
    public $schoolId;
}
?>