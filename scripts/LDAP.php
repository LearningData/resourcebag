<?php

class LDAP {
    function connect($ds, $userDomain, $password){
        if($ds) {
            $conn=ldap_bind($ds, $userDomain, $password);
            if(!$conn) return false;
            return $conn;
        } else {
            return false;
        }
    }

    function bind($server) {
        $ds = ldap_connect($server) or die("Could not connect to {$server}");
        ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);

        return $ds;
    }

    function disconnect($ds) {
        ldap_close($ds);
    }

    function search($ds, $dcs, $filter) {
        $info = array();
        $sr=ldap_search($ds, $dcs, $filter, $info);
        $info = ldap_get_entries($ds, $sr);

        return $info;
    }
}

?>