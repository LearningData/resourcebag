<?php

class HomeworkController extends ControllerBase {

    public function indexAction() {

    }

    public function answerAction($homeworkId) {
        $homework = Homework::findFirstById($homeworkId);

        if (!$homework) { echo "error"; }
        $this->view->homework = $homework;
    }

    public function uploadAnswerAction() {
        echo "Starting upload";
        if ($this->request->hasFiles() == true) {
            foreach ($this->request->getUploadedFiles() as $file){
                $homeworkFile = new HomeworkFile();
                $homeworkFile->originalName = $file->getName();
                $homeworkFile->name = $file->getName();
                $homeworkFile->size = $file->getSize();
                $homeworkFile->type = $file->getType();
                $homeworkFile->file = mysql_real_escape_string(file_get_contents($file->getTempName()));
                $homeworkFile->homeworkId = $this->request->getPost("homework-id");

                print_r($file);
                if ($homeworkFile->save()) {
                    echo "SENDED";
                } else {
                    foreach ($homeworkFile->getMessages() as $message) {
                        echo "$message \n";
                    }
                }
            }
        }
    }
}

