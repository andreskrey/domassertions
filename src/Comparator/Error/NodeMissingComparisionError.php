<?php

declare(strict_types=1);

namespace andreskrey\PHPUnit\Comparator\Error;

class NodeMissingComparisionError implements ComparisionErrorInterface
{
    const ERROR_TYPE = 'Node to compare missing';

    protected $original;

    protected $error;

    public function __construct(\DOMNode $original, string $error)
    {
        $this->original = $original;
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
        return null;
    }
}
