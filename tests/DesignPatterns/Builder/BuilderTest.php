<?php

namespace DesignPatterns\Builder;

use PHPUnit\Framework\TestCase;

class BuilderTest extends TestCase {
    /**
     * @test
     */
    public function shouldBuildBurgerChef(): void {
        //snippet burger-usage
        $chef = new BurgerChef();
        $vegieBurger = $chef->makeBurger(new VeggieBurgerBuilder());
        $americanBurger = $chef->makeBurger(new AmericanBurgerBuilder());
        //end-snippet
    }

    /**
     * @test
     */
    public function shouldBuildAUser(): void {
        //snippet user-builder-mandatory-usage
        $user = UserBuilder::aUser('keyvan', 'pass')->build();
        //end-snippet
    }

    /**
     * @test
     */
    public function shouldBuildAUserWithOptionalParameters(): void {
        //snippet user-builder-optional-usage
        $user = UserBuilder::aUser('keyvan', 'pass')
            ->withName('Keyvan Akbary')
            ->withEmail('keyvan@example.com')
            ->build();
        //end-snippet
    }
}
