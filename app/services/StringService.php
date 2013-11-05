<?php
class StringService {
    public function startsWith($text, $compare) {
        if (!$compare) { return false; }

        $text = substr($text, 0, strlen($compare));

        return strcmp($text, $compare) === 0;
    }
}