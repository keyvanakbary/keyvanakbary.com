<?php

namespace Testing\TestDoubles;

//snippet authorizer-fake
class AcceptingAuthorizerFake implements Authorizer {
    public function authorize(string $username, string $password): bool {
        return $username === 'Bob';
    }
}
//end-snippet
