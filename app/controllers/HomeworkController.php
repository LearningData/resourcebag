<?php

class HomeworkController extends ControllerBase {
    public function answerAction($homeworkId) {
        $homework = Homework::findFirstById($homeworkId);
        $user = $this->getUserBySession();

        if (!$homework) { echo "error"; }
        $this->view->homework = $homework;
    }

    public function reviewAction($homeworkId) {
        $homework = Homework::findFirstById($homeworkId);
        $user = $this->getUserBySession();

        if (!$homework) { echo "error"; }
        $this->view->homework = $homework;
    }

    public function reviewedAction($homeworkId) {
        $homework = Homework::findFirstById($homeworkId);
        $user = $this->getUserBySession();

        $homework->reviewedDate = date("Y-m-d");

        if (!$homework->save()) {
            $this->flash->error("Error to review the homework");
        } else {
            $this->flash->success("Homework was reviewed.");
        }

        return $this->response->redirect("teacher/homework/list/" . $homework->classId);
    }

    public function downloadFileAction($fileId) {
        $file = HomeworkFile::findFirst("id = $fileId");
        if (!$file) {
            $this->flash->error("Error to download file.");
        }

        header("Content-length: " . $file->size);
        header("Content-type: " . $file->type);
        header("Content-Disposition: attachment; filename=" . $file->name);

        $this->view->setRenderLevel(\Phalcon\Mvc\View::LEVEL_NO_RENDER);
        $this->response->setContent($file->file)->send();
    }

    public function submitAction($homeworkId) {
        $homework = Homework::findFirstById($homeworkId);
        $user = $this->getUserBySession();

        if (!$homework) { echo "error"; }

        $homework->submittedDate = date("Y-m-d");

        if ($homework->save()) {
            $this->flash->success("The homework was submitted.");
        } else {
            $this->flash->error("The homework was not submitted.");
        }

        $this->dispatcher->forward(
            array("controller" => "student",
                "action" => "homework",
                "params" => array("action" => "list", "classId" => $homework->classId))
        );
    }

    public function uploadFileAction() {
        $homeworkId = $this->request->getPost("homework-id");
        $description = $this->request->getPost("description");

        if ($this->request->hasFiles() == true) {
            foreach ($this->request->getUploadedFiles() as $file){
                $homeworkFile = new HomeworkFile();
                $homeworkFile->originalName = $file->getName();
                $homeworkFile->name = $file->getName();
                $homeworkFile->size = $file->getSize();
                $homeworkFile->type = $file->getType();
                $homeworkFile->file = file_get_contents($file->getTempName());
                $homeworkFile->homeworkId = $homeworkId;
                $homeworkFile->description = $description;

                if ($homeworkFile->save()) {
                    $this->flash->success("The file was uploaded.");
                } else {
                    $this->flash->error("The file was not uploaded.");
                    foreach ($homeworkFile->getMessages() as $message) {
                        $this->flash->error($message);
                    }
                }
            }
        }

        return $this->dispatcher->forward(array("action" => "answer",
            "params" => array("homeworkId" => $homeworkId)));
    }
}

