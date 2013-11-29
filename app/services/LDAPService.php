<?php
use Phalcon\Logger\Adapter\File as FileAdapter;

class LDAPService {
    private $ds;

    function __construct($ds) {
        $this->ds = $ds;
    }

    public function getDs() {
        return $this->ds;
    }

    public function setDs($ds) {
        $this->ds = $ds;
    }


    public function search($dn, $filter) {
        return LDAP::search($this->ds, $dn, $filter);
    }
}

?>