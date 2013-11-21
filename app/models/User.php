<?php
use Phalcon\Mvc\Model\Validator\Email as EmailValidator;
use Phalcon\Mvc\Model\Validator\PresenceOf;

class User extends \Phalcon\Mvc\Model {
    public $userID;
    public $schoolID;
    public $year;
    public $FirstName;
    public $LastName;
    public $Type;
    public $email;
    public $password;
    public $title;

    public function initialize() {
        $this->belongsTo("schoolId", "School", "id");
        $this->hasOne('id', 'UserPhoto', 'userId', array("alias" => "Photo"));

        $this->hasManyToMany(
            "id",
            "ClassListUser",
            "studentId",
            "classId",
            "ClassList",
            "id",
            array("alias" => "Classes")
        );

        $this->hasManyToMany(
            "id",
            "GroupMembers",
            "userId",
            "groupId",
            "Group",
            "id",
            array("alias" => "Groups")
        );

        $this->hasMany("id", "Event", "userId", array("alias" => "Events"));
        $this->hasMany("id", "Homework", "studentId", array("alias" => "Homeworks"));
    }

    public function getSource() {
        return "users";
    }

    public function school() {
        return School::findFirst("id = $this->schoolId");
    }

    public function getTeachers() {
        $conditions = "schoolId = ?1 AND type = ?2";
        $parameters = array(1 => $this->schoolId, 2 => $this->type);

        $params = array($conditions, "bind" => $parameters);

        return User::find($params);
    }

    public function getHomeworkByStatus($status) {
        $homeworks = array();

        if ($status != "") {
            $resultset = Homework::findHomeworksByStatus($this->id, $status);
            foreach ($resultset as $homework) {
                $homeworks []= $homework;
            }
        } else {
            $query = "studentId = ?1 and status <=1 order by status, dueDate";
            $params = array($query, "bind" => array(1 => $this->id));
            $pending = Homework::find($params);

            $query = "studentId = ?1 and status >=2 order by dueDate desc";
            $params = array($query, "bind" => array(1 => $this->id));
            $done = Homework::find($params);

            foreach ($pending as $homework) { $homeworks []= $homework; }
            foreach ($done as $homework) { $homeworks []= $homework; }
        }

        return $homeworks;
    }

    public static function getTypeStudent() { return "P"; }
    public static function getTypeTeacher() { return "T"; }
    public static function getTypeSchool() { return "S"; }
    public static function getTypeAdmin() { return "A"; }

    public function getController() {
        switch ($this->type) {
            case User::getTypeAdmin():
                return "admin";
            case User::getTypeTeacher():
                return "teacher";
            case User::getTypeStudent():
                return "student";
            case User::getTypeSchool():
                return "school";
        }
    }

    public function isStudent() {
        return $this->type == User::getTypeStudent();
    }

    public function isTeacher() {
        return $this->type == User::getTypeTeacher();
    }

    public function isSchool() {
        return $this->type == User::getTypeSchool();
    }

    public function isAdmin() {
        return $this->type == User::getTypeAdmin();
    }

    public function completeName() {
        return $this->name . " " . $this->lastName;
    }

    public function getTitles() {
        $t = Translation::get(Language::get(), "user");
        return array("mr" => $t->_("mr"),
            "mrs" => $t->_("mrs"), "ms" => $t->_("ms")
        );
    }

    public function validation() {
        $this->validate(new EmailValidator(array("field" => "email")));

        $this->validate(new PresenceOf(array("field" => "name")));

        if ($this->validationHasFailed() == true) { return false; }

        return true;
    }

    public function columnMap() {
        return array(
            'userID' => 'id',
            'schoolID' => 'schoolId',
            'year' => 'year',
            'FirstName' => 'name',
            'LastName' => 'lastName',
            'Type' => 'type',
            'email' => 'email',
            'password' => 'password',
            'title' => 'title'
        );
    }
}
