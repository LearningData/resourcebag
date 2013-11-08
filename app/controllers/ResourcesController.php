<?php
require "../app/services/FileService.php";
use \Phalcon\Config\Adapter\Ini as Config;

class ResourcesController extends ControllerBase {
    public function indexAction() {
        $user = Authenticate::getUser();
        if($user->isStudent()) {
            $classes = $user->classes;
        } else {
            $classes = ClassList::findByTeacherId($user->id);
        }

        $resources = array();

        foreach ($classes as $classList) {
            $files = Resource::findBySubjectId($classList->subject->id);
            if(count($files) > 0) {
                $resources[$classList->id] = array(
                    "name" => $classList->subject->name,
                    "resources" => $files
                );
            }
        }

        $this->view->classes = $resources;
    }

    public function newAction() {
        $user = Authenticate::getUser();
        $this->view->classes = ClassListService::getSubjectsByUser($user);
        $this->view->properties = ResourceProperty::find();
        $this->view->t = Translation::get(Language::get(), "resources");
    }

    public function newTagAction() {}

    public function createTagAction() {
        $property = new ResourceProperty();
        $property->name = $this->request->getPost("name");
        $property->type = $this->request->getPost("name");

        $property->save();
        return $this->response->redirect("resources/new");
    }

    public function uploadAction() {
        $user = Authenticate::getUser();
        if ($this->request->hasFiles() == true) {
            $t = Translation::get(Language::get(), "file");

            $resource = new Resource();
            $resource->description = $this->request->getPost("description");
            $resource->date = date("Y-m-d");
            $resource->teacherId = $user->id;
            $resource->subjectId = $this->request->getPost("subject-id");

            foreach ($this->request->getUploadedFiles() as $file) {
                if (!file_exists($this->getDir($resource->subjectId))) {
                    mkdir($this->getDir($resource->subjectId));
                }

                $wasMoved = move_uploaded_file($file->getTempName(),
                    $this->getDir($resource->subjectId) . $file->getName());

                if($wasMoved) {
                    $resource->fileName = $file->getName();
                    if ($resource->save()) {
                        $ids = $this->request->getPost("tags");

                        foreach ($ids as $id) {
                            $property = new ResourcesProperties();
                            $property->resourceId = $resource->id;
                            $property->propertyId = $id;
                            $property->save();
                        }

                        $this->flash->success($t->_("uploaded"));
                    } else {
                        $this->flash->error($t->_("upload-error"));
                    }
                } else {
                    $this->flash->error($t->_("upload-error"));
                }
            }

        }

        return $this->response->redirect("resources");
    }

    public function downloadAction($resourceId) {
        $resource = Resource::findFirstById($resourceId);
        $this->view->setRenderLevel(\Phalcon\Mvc\View::LEVEL_NO_RENDER);
        header('Content-Disposition: attachment; filename="'.$resource->fileName.'"');
        readfile($this->getDir($resource->subjectId) . $resource->fileName);
    }

    private function getDir($classId) {
        $config = new Config("../app/config/files-config.ini");
        $user = $this->getUserBySession();
        if (!file_exists($config->files->dir)) {
            mkdir($config->files->dir);
        }

        if (!file_exists($config->files->dir . $user->schoolId)) {
            mkdir($config->files->dir . $user->schoolId);
        }

        if (!file_exists($config->files->dir . $user->schoolId . "/resources")) {
            mkdir($config->files->dir . $user->schoolId . "/resources");
        }

        $dir = $config->files->dir . $user->schoolId . "/resources/$classId/";

        return $dir;
    }
}

?>