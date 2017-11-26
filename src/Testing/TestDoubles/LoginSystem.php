<?php

namespace Testing\TestDoubles;

class LoginSystem {
    private $authorizer;

    public function __construct(Authorizer $authorizer) {
        $this->authorizer = $authorizer;
    }

    public function login(string $user, string $pass): string {
        return $this->authorizer->authorize($user, $pass) ?
            'Hello ' . $user : 'Not logged in';
    }
}
