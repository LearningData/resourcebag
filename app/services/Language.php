<?php
use Phalcon\Mvc\User\Component;

class Language extends Component {
    public function setInitialLanguage($language) {
        if (!$language || StringService::startsWith($language, "en")) {
            $this->session->set("schoolbag-lang", "en");
        } else {
            $this->session->set("schoolbag-lang", $language);
        }
    }

    public function get() {
        return $this->session->get("schoolbag-lang");
    }
}