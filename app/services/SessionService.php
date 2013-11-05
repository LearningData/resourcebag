<?php
use Phalcon\Mvc\User\Component;

class SessionService extends Component {
    public function createSession($user) {
        $this->session->set($this->request->getServerAddress(),
            array("id" => $user->id, "name" => $user->name));
    }

    public function destroySession() {
        $this->session->remove($this->request->getServerAddress());
        $this->session->destroy();
    }
}