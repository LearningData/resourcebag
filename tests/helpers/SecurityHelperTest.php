<?php
require 'app/helpers/SecurityTag.php';

class SecurityTagTest extends PHPUnit_Framework_TestCase {
    public function setUp() {
        $this->value = "testvalue";
        $this->name = "testname";

        $this->params = array("name" => $this->name, "value" => $this->value);
    }
    public function testReturnsHiddenField() {
        $tag = SecurityTag::csrf($this->params);
        $expected = "<input type='hidden' value='" . $this->value .
             "' name='" . $this->name . "'>";

        $this->assertEquals($expected, $tag);
    }

}

?>