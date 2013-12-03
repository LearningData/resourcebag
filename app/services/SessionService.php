<?php
use Phalcon\Mvc\User\Component;

class SessionService extends Component {
    public function createSession($user, $type="schoolbag") {
        $this->session->set("schoolbag_" . $this->request->getServerAddress(),
            array("id" => $user->id,
                "name" => $user->name,
                "type" => $type));
    }

    public function destroySession() {
        $this->session->remove("schoolbag_" . $this->request->getServerAddress());
        $this->session->destroy();
    }
}