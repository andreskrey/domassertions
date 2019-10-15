<?php

declare(strict_types=1);

namespace andreskrey\Tests\PHPUnit;

use andreskrey\PHPUnit\Comparator\NodeComparator;
use andreskrey\PHPUnit\DOMDocumentComparator;
use PHPUnit\Framework\TestCase;

class DOMDocumentComparatorTest extends TestCase
{
    use FilesDataProviderTrait;

    /**
     * @dataProvider equalDocumentsDataProvider
     *
     * @param string $original
     * @param string $other
     */
    public function testDOMDocumentsAreEqual(string $original, string $other)
    {
        $originalDOM = new \DOMDocument();
        $originalDOM->loadHTML($original);
        $otherDOM = new \DOMDocument();
        $otherDOM->loadHTML($other);

        $constraint = new DOMDocumentComparator($originalDOM, new NodeComparator());

        $this->assertTrue($constraint->matches($otherDOM));
    }

    /**
     * @dataProvider nonEqualDocumentsDataProvider
     *
     * @param string $original
     * @param string $other
     */
    public function testDOMDocumentsAreNotEqual(string $original, string $other)
    {
        $originalDOM = new \DOMDocument();
        $originalDOM->loadHTML($original);
        $otherDOM = new \DOMDocument();
        $otherDOM->loadHTML($other);

        $constraint = new DOMDocumentComparator($originalDOM, new NodeComparator());

        $this->assertFalse($constraint->matches($otherDOM));
    }
}
