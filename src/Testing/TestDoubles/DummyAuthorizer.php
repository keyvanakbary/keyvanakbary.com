<?php

namespace Testing\TestDoubles;

//snippet dummy-authorizer
class DummyAuthorizer implements Authorizer {
    public function authorize(string $user, string $pass): bool {
    }
}
//end-snippet
