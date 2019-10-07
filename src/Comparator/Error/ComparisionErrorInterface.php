<?php

declare(strict_types=1);

namespace andreskrey\PHPUnit\Comparator\Error;

interface ComparisionErrorInterface
{
    public function getType(): string;

    public function getComparisionError(): string;

    public function getOriginalDOMNode(): \DOMNode;

    public function getOtherDOMNode(): \DOMNode;
}
