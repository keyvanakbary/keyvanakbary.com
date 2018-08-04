<?php

namespace Comments\BadComments {
    class CommentedCode {
        //snippet noise
        // The name
        private $name;

        // The birth date;
        private $birthDate;

        // Default constructor
        public function __construct()
        //end-snippet
        {}

        public function getAge(): int {
            return 0;
        }

        public function isTeenager(): bool {
            return false;
        }
    }

    $user = new CommentedCode();

    //snippet commented-teenager
    // Is a teenager
    if ($user->getAge() > 12 && $user->getAge() < 20)
    //end-snippet
    {}

    //snippet code-teenager
    if ($user->isTeenager())
    //end-snippet
    {}
}

namespace Comments\BadComments\sum1 {
    //snippet phpdoc
    /**
     * Sums two numbers
     * @param int num1
     * @param int num2
     * @return int
     */
    function sum($num1, $num2)
    //end-snippet
    {}
}

namespace Comments\BadComments\sum2 {
    //snippet types
    function sum(int $num1, int $num2): int
    //end-snippet
    { return $num1 + $num2; }
}
