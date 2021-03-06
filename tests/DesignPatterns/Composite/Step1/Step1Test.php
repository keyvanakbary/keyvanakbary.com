<?php

namespace DesignPatterns\Composite\Step1;

use PHPUnit\Framework\TestCase;

class CompositeTest extends TestCase {
    /**
     * @test
     */
    public function itShouldSumTransactions(): void {
        $account = new Account();
        $account->link(new Transaction(5));
        $account->link(new Transaction(10));

        $this->assertEquals(15, $account->balance());
    }

    /**
     * @test
     */
    public function itShouldSumAccountBalances(): void {
        //snippet holding-usage
        $holding1 = new Account();
        $holding1->link(new Transaction(5));

        $holding2 = new Account();
        $holding2->link(new Transaction(10));

        $overallHolding = new Account();
        $overallHolding->link($holding1);
        $overallHolding->link($holding2);

        $balance = $overallHolding->balance();
        //end-snippet

        $this->assertEquals(15, $balance);
    }
}
