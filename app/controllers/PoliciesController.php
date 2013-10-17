<?php
require "../app/services/FileService.php";
use \Phalcon\Config\Adapter\Ini as Config;

class PoliciesController extends ControllerBase {
    public function indexAction() {
        $this->getUserBySession();
        $files = FileService::listFiles($this->getDir());

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