<?php

class BurgerChef {
    public function makeBurger(BurgerBuilder $builder) {
        $builder->createBurger();
        $builder->prepareBun();
        $builder->cookPatty();
        $builder->putToppings();
 
        return $builder->getBurger();
    }
}
