<?php

namespace Testing\TestDoubles;

//snippet authorizer-stub
class AcceptingAuthorizerStub implements Authorizer {
    public function authorize(string $user, string $pass): bool {
        return true;
    }
}
//end-snippet
