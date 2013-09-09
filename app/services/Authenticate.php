<?php
class Authenticate {
    public static function authentication($email, $password) {
        $conditions = "email = ?1 AND password = ?2";
        $parameters = array(1 => $email, 2 => $password);

        $user = User::findFirst(array($conditions,"bind" => $parameters));

        return $user;
    }
}
?>