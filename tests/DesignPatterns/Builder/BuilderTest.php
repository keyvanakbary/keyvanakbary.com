<?php

namespace DesignPatterns\Builder;

class BuilderTest extends \PHPUnit_Framework_TestCase {
    /**
     * @test
     */
    public function shouldBuildBurgerChef() {
        //snippet burger-usage
        $chef = new BurgerChef();
        $vegieBurger = $chef->makeBurger(new VeggieBurgerBuilder());
        $americanBurger = $chef->makeBurger(new AmericanBurgerBuilder());
        //end-snippet
    }

    /**
     * @test
     */
    public function shouldBuildAUser() {
        //snippet user-builder-mandatory-usage
        $user = UserBuilder::aUser('keyvan', 'pass')->build();
        //end-snippet
    }

    /**
     * @test
     */
    public function shouldBuildAUserWithOptionalParameters() {
        //snippet user-builder-optional-usage
        $user = UserBuilder::aUser('keyvan', 'pass')
            ->withName('Keyvan Akbary')
            ->withEmail('keyvan@example.com')
            ->build();
        //end-snippet
    }
}
