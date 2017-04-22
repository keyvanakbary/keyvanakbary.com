<?php

namespace DesignPatterns\Composite\Step1;

class CompositeTest extends \PHPUnit_Framework_TestCase {
    /**
     * @test
     */
    public function itShouldSumTransactions() {
        $account = new Account();
        $account->link(new Transaction(5));
        $account->link(new Transaction(10));

        $this->assertEquals(15, $account->balance());
    }

    /**
     * @test
     */
    public function itShouldSumAccountBalances() {
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
