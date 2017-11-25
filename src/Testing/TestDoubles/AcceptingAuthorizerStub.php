<?php

namespace Testing\TestDoubles;

//snippet authorizer-stub
class AcceptingAuthorizerStub implements Authorizer {
    public function authorize(string $username, string $password): bool {
        return true;
    }
}
//end-snippet
