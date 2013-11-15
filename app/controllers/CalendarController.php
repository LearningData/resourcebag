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

        $event = new Event();
        $event->start = "";
        $event->end = "";
        $event->url = "";

        $this->view->event = $event;
    }

    public function editAction($eventId) {
        $event = Event::findFirstById($eventId);
        if($event) {
            $this->view->options = array(false => "False", true => "True");
            $this->view->event = $event;
            $this->setTokenValues();
        }
    }

    public function indexAction() {
        $this->setTokenValues();
        $this->getUserBySession();
    }

    public function updateAction() {
        $user = Authenticate::getUser();

        if($this->isValidPost()) {
            $event = Event::findFirstById($this->request->getPost("event-id"));
            if($event) {
                $event = $this->populeEvent($event);
            }

            if($event->save()){
                $this->flash->success($this->view->t->_("event-updated"));
            } else {
                $this->appendErrorMessages($event->getMessages());
            }

            $this->response->redirect($user->getController() . "/calendar");
        }
    }

    public function createAction() {
        if($this->isValidPost()) {
            $user = $this->getUserBySession();
            $event = $this->populeEvent(new Event());
            $event->createdAt = date("Y-m-d H:i:s", time());

            if($event->save()) {
                $this->flash->success($this->view->t->_("event-created-message"));
            } else {
                $this->appendErrorMessages($event->getMessages());
            }

            $this->response->redirect($user->getController() . "/calendar");
        }
    }

    public function removeAction($eventId) {
        $event = Event::findFirstById($eventId);
        if($event && $event->delete()) {
            $this->flash->success($this->view->t->_("event-deleted"));
        } else {
            $this->flash->error($this->view->t->_("event-not-deleted"));
        }

        return $this->dispatcher->forward(
            array("controller" => "calendar", "action" => "index")
        );
    }

    private function populeEvent($event) {
        if(!$this->request->getPost("user-id")){
            $event->userId = $this->view->user->id;
        }
        $event->title = $this->request->getPost("title");
        $event->location = $this->request->getPost("location");
        $event->contact = $this->request->getPost("contact");
        $event->description = $this->request->getPost("description");
        $event->start = $this->request->getPost("start");
        $event->end = $this->request->getPost("end");
        $event->url = $this->request->getPost("link");
        $event->allDay = $this->request->getPost("allDay");

        return $event;
    }
}
?>