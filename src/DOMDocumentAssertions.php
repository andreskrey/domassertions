<?php

declare(strict_types=1);

namespace andreskrey\PHPUnit;

use andreskrey\PHPUnit\Comparator\NodeComparator;
use PHPUnit\Framework\Assert;

/**
 * Trait DOMDocumentAssertions.
 */
trait DOMDocumentAssertions
{
    /**
     * @param \DOMDocument $expected
     * @param \DOMDocument $actual
     * @param string       $message
     */
    public static function assertDOMDocumentHasSameStructure(\DOMDocument $expected, \DOMDocument $actual, string $message = ''): void
    {
        Assert::assertThat($expected, self::sameDOMDocumentStructure($actual), $message);
    }

    /**
     * @param \DOMDocument $document
     *
     * @return Constraint\SameDOMDocumentStructure
     */
    public static function sameDOMDocumentStructure(\DOMDocument $document): Constraint\SameDOMDocumentStructure
    {
        return new Constraint\SameDOMDocumentStructure($document, new NodeComparator());
    }
}
