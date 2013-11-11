<?php

class DownloadController extends ControllerBase {
    public function homeworkAction($fileId) {
        $file = HomeworkFile::findFirstById($fileId);
        $this->setContent($file);
    }

    public function noticeboardAction($fileId) {
        $file = NoticeBoardFile::findFirst($fileId);
        $this->setContent($file);
    }

    public function photoAction() {
        $user = $this->getUserBySession();
        $photo = UserPhoto::findFirstByUserId($user->id);
        header("Content-type: " . $photo->type);
        ob_clean();
        $this->view->setRenderLevel(\Phalcon\Mvc\View::LEVEL_NO_RENDER);
        $this->response->setContent($photo->file)->send();
    }

    private function setContent($file) {
        $t = Translation::get(Language::get(), "config");
        if (!$file) {
            $this->flash->error($t->_("download-error"));
        }

        header("Content-length: " . $file->size);
        header("Content-type: " . $file->type);
        header("Content-Disposition: attachment; filename=" . $file->name);
        ob_clean();

        $this->view->setRenderLevel(\Phalcon\Mvc\View::LEVEL_NO_RENDER);
        $this->response->setContent($file->file)->send();
    }
}

