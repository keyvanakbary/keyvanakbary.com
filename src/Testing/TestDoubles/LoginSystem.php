<?php

namespace Testing\TestDoubles;

class LoginSystem {
    private $authorizer;

    public function __construct(Authorizer $authorizer) {
        $this->authorizer = $authorizer;
    }

    public function login(string $username, string $password): string {
        return $this->authorizer->authorize($username, $password) ?
            'Hello ' . $username : 'Not logged in';
    }
}
