<?php
    class SecurityTag extends \Phalcon\Tag {
        public static function csrf($parameters) {
            $tokenKey = $parameters['name'];
            $token = $parameters['value'];

            return "<input type='hidden' value='$token' name='$tokenKey'>";
        }
    }
?>