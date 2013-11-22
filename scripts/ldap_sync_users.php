<?php
class LDAP {

}
$user = "admin";
$dc1 = "example";
$dc2 = "com";
$server = "ldap://127.0.0.1/";
$password = "LD46marmita";
$userDomain='cn='.$user.',dc='.$dc1.',dc='.$dc2;

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

function listStudents($ds, $dcs, $filter) {
    $info = search($ds, $dcs, $filter);

    for ($i=0; $i < $info["count"]; $i++) {
        echo $info[$i]["uid"][0] . " - " . $info[$i]["cn"][0] . "\n";
    }
}

function listTeachers($ds, $dcs, $filter) {
    $info = search($ds, $dcs, $filter);

    for ($i=0; $i < $info["count"]; $i++) {
        echo $info[$i]["uid"][0] . " - " .
             $info[$i]["cn"][0] . " - " .
             $info[$i]["mail"][0] . "\n";
    }
}


$ds = bind($server);
$conn = connect($ds, $userDomain, $password);

// // listStudents($ds, "dc=$dc1,dc=$dc2", "ou=Student");
// listTeachers($ds, "dc=$dc1,dc=$dc2", "ou=Student");
// disconnect($ds);

// ?>