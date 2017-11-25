<?php

namespace DesignPatterns\Composite\Step1;

//snippet account
class Account implements Holding {
    private $holdings = [];

    public function link(Holding $holding): void {
        $this->holdings[] = $holding;
    }

    public function balance(): int {
        $sum = 0;
        foreach ($this->holdings as $holding) {
            $sum += $holding->balance();
        }

        return $sum;
    }
}
//end-snippet
