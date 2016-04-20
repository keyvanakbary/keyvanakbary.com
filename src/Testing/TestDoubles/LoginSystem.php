<?php

namespace Testing\TestDoubles;

class LoginSystem {
    private $authorizer;

    public function __construct(Authorizer $authorizer) {
        $this->authorizer = $authorizer;
    }

    public function login($username, $password) {
        return $this->authorizer->authorize($username, $password) ?
            'Hello ' . $username : 'Not logged in';
    }
}
