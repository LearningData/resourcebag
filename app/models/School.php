<?php

class School extends \Phalcon\Mvc\Model {

    public function getSource() {
        return "schoolinfo";
    }
    /**
     *
     * @var integer
     */
    public $schoolID;

    /**
     *
     * @var string
     */
    public $SchoolName;

    /**
     *
     * @var string
     */
    public $Address;

    /**
     *
     * @var string
     */
    public $SchoolPath;

    /**
     *
     * @var string
     */
    public $AccessCode;

    /**
     *
     * @var string
     */
    public $TeacherAccessCode;

    /**
     *
     * @var integer
     */
    public $allTY;

}
