<?php

namespace Comments\BadComments;

use PHPUnit\Framework\TestCase;
use Comments\BadComments\CommentedCode;

class CommentedCodeTest extends TestCase {
    /**
     * @test
     */
    public function itShouldCreateFile(): void {
        $c = new CommentedCode();
    }

    /**
     * @test
     */
    public function itShouldCreateFile2(): void {
        \Comments\BadComments\sum1\sum(1, 2);
        \Comments\BadComments\sum2\sum(1, 2);
    }
}
