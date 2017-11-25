<?php

namespace DesignPatterns\Builder;

//snippet burger-chef
class BurgerChef {
    public function makeBurger(BurgerBuilder $builder): Burger {
        $builder->createBurger();
        $builder->prepareBun();
        $builder->cookPatty();
        $builder->putToppings();

        return $builder->getBurger();
    }
}
//end-snippet
