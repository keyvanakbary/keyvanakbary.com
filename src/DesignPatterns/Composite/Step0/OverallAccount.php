<?php

namespace DesignPatterns\Composite\Step0;

//snippet overall-account
class OverallAccount {
    private $accounts = [];

    public function link(Account $account): void {
        $this->accounts[] = $account;
    }

    public function balance(): int {
        $sum = 0;
        foreach ($this->accounts as $account) {
            $sum += $account->balance();
        }

        return $sum;
    }
}
//end-snippet
