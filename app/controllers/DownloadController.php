<?php

class DownloadController extends ControllerBase {
    public function homeworkAction($fileId) {
        $file = HomeworkFile::findFirst("id = $fileId");
        $this->setContent($file);
    }

    public function noticeboardAction($fileId) {
        $file = NoticeBoardFile::findFirst($fileId);
        $this->setContent($file);
    }

    public function photoAction() {
        $user = $this->getUserBySession();
        $photo = UserPhoto::findFirst("userId = " . $user->id);
        header("Content-type: " . $photo->type);
        $this->view->setRenderLevel(\Phalcon\Mvc\View::LEVEL_NO_RENDER);
        $this->response->setContent($photo->file)->send();
    }

    private function setContent($file) {
        if (!$file) {
            $this->flash->error("Error to download file.");
        }

        header("Content-length: " . $file->size);
        header("Content-type: " . $file->type);
        header("Content-Disposition: attachment; filename=" . $file->name);

        $this->view->setRenderLevel(\Phalcon\Mvc\View::LEVEL_NO_RENDER);
        $this->response->setContent($file->file)->send();
    }
}
