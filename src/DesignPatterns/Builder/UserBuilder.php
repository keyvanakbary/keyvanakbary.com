<?php

namespace DesignPatterns\Builder;

//snippet user-builder
class UserBuilder {
    private $username;
    private $password;
    private $email = '';
    private $name = '';

    private function __construct(string $username, string $password) {
        $this->username = $username;
        $this->password = $password;
    }

    public static function aUser(string $username, string $password): self {
        return new self($username, $password);
    }

    public function withName(string $name): self {
        $this->name = $name;

        return $this;
    }

    public function withEmail(string $email): self {
        $this->email = $email;

        return $this;
    }

    public function build(): User {
        return new User($this->username, $this->password, $this->email, $this->name);
    }
}
//end-snippet
