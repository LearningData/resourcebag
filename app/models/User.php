<?php
use Phalcon\Mvc\Model\Validator\Email as EmailValidator;
use Phalcon\Mvc\Model\Validator\PresenceOf;

class User extends \Phalcon\Mvc\Model {

    public function getSource() {
        return "users";
    }

    /**
     *
     * @var integer
     */
    public $userID;

    /**
     *
     * @var integer
     */
    public $schoolID;

    /**
     *
     * @var integer
     */
    public $year;

    /**
     *
     * @var string
     */
    public $FirstName;

    /**
     *
     * @var string
     */
    public $LastName;

    /**
     *
     * @var string
     */
    public $Type;

    /**
     *
     * @var string
     */
    public $email;

    /**
     *new
     * @var string
     */
    public $password;

    /**
     * Validations and business logic
     */
    public function validation() {
        $this->validate(new EmailValidator(array("field" => "email")));

        $this->validate(new PresenceOf(array("field" => "FirstName")));

        if ($this->validationHasFailed() == true) { return false; }

        return true;
    }
}
