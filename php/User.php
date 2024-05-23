<?php

/**
 * Class User
 * Represents a user with basic information.
 * 
 * @property int    $id           User's ID.
 * @property string $email        User's email.
 * @property string $password     User's password.
 * @property string $nameOfPhoto  User's photo file name.
 */

class User {
    public $id;
    public $email;
    public $password;
    public $nameOfPhoto;
  
     /**
     * User constructor.
     *
     * @param int    $id           User's ID.
     * @param string $email        User's email.
     * @param string $password     User's password.
     * @param string $nameOfPhoto  User's photo file name.
     */
    
    public function __construct( $id,$email,$password,$nameOfPhoto) {
        $this->id = $id;
        $this->email = $email;
        $this->password = $password;
        $this->nameOfPhoto = $nameOfPhoto;
    }
  }
?>