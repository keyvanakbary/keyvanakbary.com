<?php

namespace DesignPatterns\Composite\Step0;

//snippet account
class Account {
    private $transactions = [];

    public function link(Transaction $transaction): void {
        $this->transactions[] = $transaction;
    }

    public function balance(): int {
        $sum = 0;
        foreach ($this->transactions as $transaction) {
            $sum += $transaction->value();
        }

        return $sum;
    }
}
//end-snippet
