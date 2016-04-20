<?php

namespace Testing\TestDoubles;

//snippet authorizer-fake
class AcceptingAuthorizerFake implements Authorizer {
    public function authorize($username, $password) {
        return $username === 'Bob';
    }
}
//end-snippet
