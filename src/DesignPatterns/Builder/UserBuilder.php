<?php

namespace DesignPatterns\Builder;

//snippet user-builder
class UserBuilder {
    private $username;
    private $password;
    private $email = '';
    private $name = '';

    private function __construct($username, $password) {
        $this->username = $username;
        $this->password = $password;
    }

    public static function aUser($username, $password) {
        return new self($username, $password);
    }

    public function withName($name) {
        $this->name = $name;

        return $this;
    }

    public function withEmail($email) {
        $this->email = $email;

        return $this;
    }

    public function build() {
        return new User($this->username, $this->password, $this->email, $this->name);
    }
}
//end-snippet