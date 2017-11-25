<?php

namespace DesignPatterns\Builder;

//snippet user
class User {
    private $username;
    private $password;
    private $email;
    private $name;

    public function __construct(
        string $username,
        string $password,
        string $email = '',
        string $name = ''
    ) {
        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
        $this->name = $name;
    }

    public static function create(string $username, string $password) {
        return new self($username, $password);
    }

    public static function createWithEmail(
        string $username,
        string $password,
        string $email
    ) {
        return new self($username, $password, $email);
    }

    public static function createWithName(
        string $username,
        string $password,
        string $name
    ) {
        return new self($username, $password, '', $name);
    }

    public static function createWithEmailAndName(
        string $username,
        string $password,
        string $email,
        string $name
    ) {
        return new self($username, $password, $email, $name);
    }
}
//end-snippet
