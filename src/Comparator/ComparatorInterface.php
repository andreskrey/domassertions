<?php

namespace andreskrey\PHPUnit\Comparator;

interface ComparatorInterface
{
    public function compare(\DOMNode $original, ?\DOMNode $other): ComparisionErrorList;
}
