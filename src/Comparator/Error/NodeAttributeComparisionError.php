<?php

declare(strict_types=1);

namespace andreskrey\PHPUnit\Comparator\Error;

class NodeAttributeComparisionError implements ComparisionErrorInterface
{
    const ERROR_TYPE = 'Different node attributes';

    protected $original;

    protected $other;

    protected $error;

    public function __construct(\DOMNode $original, \DOMNode $other, string $error)
    {
        $this->original = $original;
        $this->other = $other;
        $this->error = $error;
    }

    public function getType(): string
    {
        return self::ERROR_TYPE;
    }

    public function getComparisionError(): string
    {
        return $this->error;
    }

    public function getOriginalDOMNode(): \DOMNode
    {
        return $this->original;
    }

    public function getOtherDOMNode(): \DOMNode
    {
        return $this->other;
    }
}
