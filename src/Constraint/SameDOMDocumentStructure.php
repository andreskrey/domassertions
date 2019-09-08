<?php
declare(strict_types=1);

namespace andreskrey\PHPUnit\Constraint;

use andreskrey\PHPUnit\Comparator\NodeComparator;
use andreskrey\PHPUnit\Iterator\DOMNodeIterator;
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
     * @var NodeComparator
     */
    protected $comparator;

    /**
     * SameDOMDocumentStructure constructor.
     *
     * @param \DOMDocument $document
     * @param NodeComparator $comparator
     */
    public function __construct(\DOMDocument $document, NodeComparator $comparator)
    {
        $this->original = $document;
        $this->comparator = $comparator;
    }

    /**
     * {@inheritDoc}
     */
    protected function matches($other): bool
    {
        $test = $this->compareDocuments($this->original, $other);
        $test1 = 1;
    }

    /**
     * {@inheritDoc}
     */
    public function toString(): string
    {
        return 'same DOMDocument structure';
    }

    protected function compareDocuments(\DOMDocument $original, \DOMDocument $other): bool
    {
        $lhs = new DOMNodeIterator($original);
        $rhs = new DOMNodeIterator($other);

        $result = $this->traverse($lhs, $rhs);

        return $failures;
    }

    protected function traverse(DOMNodeIterator $lhs, DOMNodeIterator $rhs)
    {
        while ($lhs->valid()) {
            echo $lhs->getDepth() . PHP_EOL;
            try {
                if (!$this->comparator->compare($lhs->current(), $rhs->current())) {
                    throw new \UnexpectedValueException();
                }

                if ($lhs->hasChildren()) {
                    if ($rhs->hasChildren()) {
                        $this->traverse($lhs->getChildren(), $rhs->getChildren());
                    } else{
                        throw new \UnexpectedValueException();
                    }
                }

                $lhs->next();
                $rhs->next();
            } catch (\UnexpectedValueException $exception) {
                $lhs->current()->setIsEqual(false);
            }
        }
    }
}
