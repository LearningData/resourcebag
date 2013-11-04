<?php
use Phalcon\Translate\Adapter\NativeArray;

class Translation {
    public static function get($language, $file) {
        require "../app/lang/$language/$file.php";
        return new NativeArray(array("content" => $messages));
    }
}
?>