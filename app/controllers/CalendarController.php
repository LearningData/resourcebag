<?php
class CalendarController extends ControllerBase {
    public function newAction(){
        $this->getUserBySession();
    }

    public function createAction() {
        $user = $this->getUserBySession();
        $event = new Event();

        $event->userId = $user->id;
        $event->title = $this->request->getPost("title");
        $event->location = $this->request->getPost("location");
        $event->contact = $this->request->getPost("contact");
        $event->description = $this->request->getPost("description");
        $event->start = $this->request->getPost("start");
        $event->end = $this->request->getPost("end");
        $event->link = $this->request->getPost("link");
        $event->allDay = 0;
        $event->createdAt = date("Y-m-d H:i:s", time());

        if($event->save()) {
            $this->flash->success("Event was created.");
        } else {
            $this->appendErrorMessages($event->getMessages());
        }

        $this->response->redirect($user->getController() . "/calendar");
    }
}
?>