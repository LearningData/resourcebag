<?php
require "../app/services/FileService.php";
use \Phalcon\Config\Adapter\Ini as Config;

class PoliciesController extends ControllerBase {
    public function indexAction() {
        $this->getUserBySession();
        $files = FileService::listFiles($this->getDir());
        $this->view->t = Translation::get(Language::get(), "policies");

        $filesAndExtensions = array();

        foreach($files as $file) {
            $path_parts = pathinfo($file);
            $extension = $path_parts["extension"];

            if ($extension != "pdf") {
                $extension = "generic";
            }

            $filesAndExtensions []= array("name" => $file,
                "extension" => $extension);
        }

        $this->view->files = $filesAndExtensions;
    }

    public function newAction() {}

    public function uploadAction() {
        if ($this->request->hasFiles() == true) {
            $t = Translation::get(Language::get(), "file");

            foreach ($this->request->getUploadedFiles() as $file) {
                $wasMoved = move_uploaded_file($file->getTempName(),
                    $this->getDir() . $file->getName());

                if($wasMoved) {
                    $this->flash->success($t->_("uploaded"));
                } else {
                    $this->flash->error($t->_("upload-error"));
                }
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