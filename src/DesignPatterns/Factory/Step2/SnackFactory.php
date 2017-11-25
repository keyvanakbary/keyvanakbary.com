<?php

namespace DesignPatterns\Factory\Step2;

use DesignPatterns\Factory\Step1\Chocolate;
use DesignPatterns\Factory\Step1\Chips;
use DesignPatterns\Factory\Step1\Sandwich;
use DesignPatterns\Factory\Step1\Snack;
use Exception;

//snippet snack-factory
class SnackFactory {
    public function create(int $code): Snack {
        switch($code) {
            case 0:
                return new Chocolate;
            case 1:
                return new Chips;
            case 2:
                return new Sandwich;
        }

        throw new Exception('No snack for code ' . $code);
    }
}
//end-snippet
