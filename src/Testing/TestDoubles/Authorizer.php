<?php

namespace Testing\TestDoubles;

//snippet authorizer
interface Authorizer {
    public function authorize(string $user, string $pass): bool;
}
//end-snippet
