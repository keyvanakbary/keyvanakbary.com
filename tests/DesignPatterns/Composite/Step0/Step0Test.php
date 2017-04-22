<?php

namespace DesignPatterns\Composite\Step0;

class CompositeTest extends \PHPUnit_Framework_TestCase {
    /**
     * @test
     */
    public function itShouldSumTransactions() {
        //snippet account-usage
        $account = new Account();
        $account->link(new Transaction(5));
        $account->link(new Transaction(10));

        $balance = $account->balance();
        //end-snippet
        $this->assertEquals(15, $balance);
    }

    /**
     * @test
     */
    public function itShouldSumBalances() {
        //snippet overall-account-usage
        $account1 = new Account();
        $account1->link(new Transaction(5));

        $account2 = new Account();
        $account2->link(new Transaction(10));

        $overallAccount = new OverallAccount();
        $overallAccount->link($account1);
        $overallAccount->link($account2);

        $balance = $overallAccount->balance();
        //end-snippet

        $this->assertEquals(15, $balance);
    }
}
