<?php
use Phalcon\Translate\Adapter\NativeArray;

class Translation {
    public static function get($language, $file) {
        $globalMessages = Translation::getGlobalMessages($language);

        if (file_exists("../app/lang/$language/$file.php")) {
            require "../app/lang/$language/$file.php";
        } else {
            require "../app/lang/en/$file.php";
        }

        $messages = array_merge($globalMessages, $messages);

        return new NativeArray(array("content" => $messages));
    }

    private function getGlobalMessages($language) {
        if (file_exists("../app/lang/$language/schoolbag.php")) {
            require "../app/lang/$language/schoolbag.php";
        } else {
            require "../app/lang/en/schoolbag.php";
        }

        return $messages;
    }
}
?>