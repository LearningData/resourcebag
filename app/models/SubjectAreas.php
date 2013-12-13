<?php

class SubjectAreas extends \Phalcon\Mvc\Model {
    public $id;
    public $subjectId;
    public $areaId;

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
            if(!SubjectAreas::findFirstBySubjectId($subject->id)) {
                $freeSubjects []= $subject;
            }
        }

        return $freeSubjects;
    }

    public function columnMap() {
        return array(
            'id' => 'id',
            'subjectId' => 'subjectId',
            'areaId' => 'areaId'
        );
    }
}
