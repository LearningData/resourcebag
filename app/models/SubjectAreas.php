<?php

class SubjectAreas extends \Phalcon\Mvc\Model {
    public $id;
    public $subjectId;
    public $areaId;
    public $schoolId;
    public $cohortId;

    public function getAreas() {
        $areas = $this->getModelsManager()->createBuilder()
            ->from("Subject")
            ->join("SubjectAreas", "Subject.id = SubjectAreas.areaId")
            ->groupBy("name")
            ->getQuery()
            ->execute();

        return $areas;
    }

    public function getSubjectsByArea($subjectId) {
        $areas = $this->getModelsManager()->createBuilder()
            ->from("Subject")
            ->join("SubjectAreas", "Subject.id = SubjectAreas.subjectId")
            ->where("areaId = $subjectId")
            ->getQuery()
            ->execute();

        return $areas;
    }

    public function getFreeSubjects() {
        $freeSubjects = array();

        foreach(Subject::find() as $subject) {
            if(!SubjectAreas::findFirst("subjectId = " . $subject->id)) {
                $freeSubjects []= $subject;
            }
        }

        return $freeSubjects;
    }

    public function getSubjectsGrouped() {
        $areas = $this->getAreas();
        $options = array();

        foreach ($areas as $area) {
            $subjects = $this->getSubjectsByArea($area->id);

            $options []= array("area" => $area->name,
                "subjects" => $subjects->toArray());
        }

        $freeSubjects = $this->getFreeSubjects();

        if(count($freeSubjects) > 0) {
            $options []= array("area" => "free",
                "subjects" => $freeSubjects);
        }

        return $options;
    }

    public function columnMap() {
        return array(
            'id' => 'id',
            'subjectId' => 'subjectId',
            'areaId' => 'areaId',
            'cohortId' => 'cohortId',
            'schoolId' => 'schoolId'
        );
    }
}
