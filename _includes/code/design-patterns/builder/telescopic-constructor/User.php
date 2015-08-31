<?php

class User {
    private $username;
    private $password;
    private $email;
    private $name;

    public function __construct($username, $password, $email = '', $name = '') {
        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
        $this->name = $name;
    }

    public static function create($username, $password) {
        return new self($username, $password);
    }

    public static function createWithEmail($username, $password, $email) {
        return new self($username, $password, $email);
    }

    public static function createWithName($username, $password, $name) {
        return new self($username, $password, '', $name);
    }

    public static function createWithEmailAndName($username, $password, $email, $name) {
        return new self($username, $password, $email, $name);
    }
}
