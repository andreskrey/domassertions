<?php
declare(strict_types=1);

namespace andreskrey\PHPUnit\Constraint;

use PHPUnit\Framework\Constraint\Constraint;

/**
 * Class SameDOMDocumentStructure
 * @package andreskrey\PHPUnit\Constraint
 */
class SameDOMDocumentStructure extends Constraint
{
    /**
     * @var \DOMDocument
     */
    protected $original;

    /**
     * SameDOMDocumentStructure constructor.
     *
     * @param \DOMDocument $document
     */
    public function __construct(\DOMDocument $document)
    {
        $this->original = $document;
    }

    /**
     * {@inheritDoc}
     */
    protected function matches($other): bool
    {
        return false;
    }

    /**
     * {@inheritDoc}
     */
    public function toString(): string
    {
        return 'same DOMDocument structure';
    }
}
