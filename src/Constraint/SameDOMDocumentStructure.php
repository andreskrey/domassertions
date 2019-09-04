<?php
declare(strict_types=1);

namespace andreskrey\PHPUnit\Constraint;

use andreskrey\PHPUnit\Comparator\NodeComparator;
use andreskrey\PHPUnit\Iterator\NodeIterator;
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
        $test = $this->compareDocuments($this->original, $other, new NodeComparator());
        $test1 = 1;
    }

    /**
     * {@inheritDoc}
     */
    public function toString(): string
    {
        return 'same DOMDocument structure';
    }

    protected function compareDocuments(\DOMDocument $original, \DOMDocument $other, NodeComparator $comparator): bool
    {
        $failures = false;
        $lhs = new NodeIterator($original);
        $rhs = new NodeIterator($other);

        while ($lhs->valid()) {
            try {
                if (!$comparator->compare($lhs->current(), $rhs->current())) {
                    throw new \UnexpectedValueException();
                }

                $lhs->next();
                $rhs->next();
            } catch (\OutOfBoundsException | \UnexpectedValueException $exception) {
                $failures = true;
                $lhs->current()->setIsEqual(false);
            }
        }

        return $failures;
    }
}
