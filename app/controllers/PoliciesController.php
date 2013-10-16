<?php
require "../app/services/FileService.php";
use \Phalcon\Config\Adapter\Ini as Config;

class PoliciesController extends ControllerBase {
    public function indexAction() {
        $this->getUserBySession();
        $this->view->files = FileService::listFiles($this->getDir());
    }

    public function newAction() {}

    public function uploadAction() {
        if ($this->request->hasFiles() == true) {
            foreach ($this->request->getUploadedFiles() as $file) {
                move_uploaded_file($file->getTempName(),
                    $this->getDir() . $file->getName());
            }

        }

        return $this->response->redirect("policies");
    }

    public function downloadAction($fileName) {
        $this->view->setRenderLevel(\Phalcon\Mvc\View::LEVEL_NO_RENDER);
        header('Content-Disposition: attachment; filename="'.$fileName.'"');
        readfile($this->getDir() . $fileName);
    }

    private function getDir() {
        $config = new Config("../app/config/files-config.ini");
        $user = $this->getUserBySession();
        $dir = $config->files->dir . $user->schoolId . "/";

        return $dir;
    }
}

?>