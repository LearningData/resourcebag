<?php
use Phalcon\Translate\Adapter\NativeArray;

class Translation {
    public static function get($language, $file) {
        $globalMessages = Translation::getGlobalMessages($language);

        require "../app/lang/$language/$file.php";
        $messages = array_merge($globalMessages, $messages);

        return new NativeArray(array("content" => $messages));
    }

    private function getGlobalMessages($language) {
        require "../app/lang/$language/schoolbag.php";
        return $messages;
    }
}
?>