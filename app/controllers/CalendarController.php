<?php
class CalendarController extends ControllerBase {
    public function beforeExecuteRoute($dispatcher){
        $user = Authenticate::getUser();

        if(!$user) { return $this->response->redirect("index"); }

        $this->view->t = Translation::get(Language::get(), "calendar");
    }

    public function newAction(){
        $this->getUserBySession();
        $this->setTokenValues();
        $this->view->options = array(false => "False", true => "True");
    }

    public function indexAction() {
        $this->setTokenValues();
        $this->getUserBySession();
    }

    public function createAction() {
        if($this->isValidPost()) {
            $user = $this->getUserBySession();
            $event = new Event();

            $event->userId = $user->id;
            $event->title = $this->request->getPost("title");
            $event->location = $this->request->getPost("location");
            $event->contact = $this->request->getPost("contact");
            $event->description = $this->request->getPost("description");
            $event->start = $this->request->getPost("start");
            $event->end = $this->request->getPost("end");
            $event->url = $this->request->getPost("link");
            $event->allDay = $this->request->getPost("allDay");
            $event->createdAt = date("Y-m-d H:i:s", time());

            if($event->save()) {
                $this->flash->success($this->view->t->_("event-created-message"));
            } else {
                $this->appendErrorMessages($event->getMessages());
            }

            $this->response->redirect($user->getController() . "/calendar");
        }
    }
}
?>