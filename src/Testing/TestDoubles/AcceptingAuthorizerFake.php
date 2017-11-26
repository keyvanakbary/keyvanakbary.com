<?php

namespace Testing\TestDoubles;

//snippet authorizer-fake
class AcceptingAuthorizerFake implements Authorizer {
    public function authorize(string $user, string $pass): bool {
        return $user === 'Bob';
    }
}
//end-snippet
