<?php


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
    // public function validation() {
    //     $this->validate(
    //         new Email(
    //             array(
    //                 "field"    => "email",
    //                 "required" => true,
    //             )
    //         )
    //     );
    //     if ($this->validationHasFailed() == true) {
    //         return false;
    //     }
    // }
}
