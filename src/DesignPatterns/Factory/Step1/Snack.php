<?php

namespace DesignPatterns\Factory\Step1;

//snippet snacks
interface Snack {
    public function description();
    public function price();
}

class Chocolate implements Snack {
    public function description() {
        return 'delicious chocolate';
    }

    public function price() {
        return 1;
    }
}

class Chips implements Snack {
    public function description() {
        return 'crunchy chips';
    }

    public function price() {
        return 1.2;
    }
}

class Sandwich implements Snack {
    public function description() {
        return 'tasty sandwich';
    }

    public function price() {
        return 2.5;
    }
}
//end-snippet
