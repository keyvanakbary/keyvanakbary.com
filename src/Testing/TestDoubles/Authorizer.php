<?php

namespace Testing\TestDoubles;

//snippet authorizer
interface Authorizer {
    /**
     * @return boolean
     */
    public function authorize($username, $password);
}
//end-snippet
