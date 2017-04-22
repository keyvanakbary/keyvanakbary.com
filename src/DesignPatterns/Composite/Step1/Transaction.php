<?php

namespace DesignPatterns\Composite\Step1;

//snippet transaction
class Transaction implements Holding {
    public $value;

    public function __construct(int $value) {
        $this->value = $value;
    }

    public function balance(): int {
        return $this->value;
    }
}
//end-snippet
