<?php
echo "Starting the script\n";

$user = "admin";
$dc1 = "example";
$dc2 = "com";
$server = "ldap://127.0.0.1/";
$password = "LD46marmita";
$userDomain='cn='.$user.',dc='.$dc1.',dc='.$dc2;

function connect($ds, $userDomain, $password){
    print "Connecting\n";

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

function disconnect($conn) {
    echo "Disconnecting\n";
    ldap_close($conn);
}

$ds = bind($server);
$conn = connect($ds, $userDomain, $password);
echo "I'm connected\n";
disconnect($ds);
print "I'm disconnected\n";

?>