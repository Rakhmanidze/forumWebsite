<?php

/**
 * Class CheckUser
 *
 * @property bool $emailCheck    Indicates whether the email exists.
 * @property bool $passwordCheck Indicates whether the password matches with the password of email.
 * Represents a data structure for checking user credentials, including email and password validation.
 */

class CheckUser {
    public $emailCheck;
    public $passwordCheck;

     /**
     * CheckUser constructor.
     *
     * @param bool $emailCheck    Indicates whether the email is exists.
     * @param bool $passwordCheck Indicates whether the password matches with the password of email.
     */
    
    public function __construct($emailCheck,$passwordCheck) {
        $this->emailCheck = $emailCheck;
        $this->passwordCheck = $passwordCheck;

    }
  }
