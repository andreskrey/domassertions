<?php
declare(strict_types=1);

namespace andreskrey\PHPUnit\Constraint;

use andreskrey\PHPUnit\Comparator\ComparisionErrorList;
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
     * @var ComparisionErrorList[]
     */
    protected $errors = [];

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
        $lhs = new DOMNodeIterator($this->original);
        $rhs = new DOMNodeIterator($other);

        return (bool)$this->traverse($lhs, $rhs);
    }

    /**
     * {@inheritDoc}
     */
    public function toString(): string
    {
        return 'has same DOMDocument structure';
    }

    /**
     * {@inheritDoc}
     */
    protected function additionalFailureDescription($other): string
    {
        return 'Here goes the diff';
    }

    /**
     * @param DOMNodeIterator $lhs
     * @param DOMNodeIterator $rhs
     * @return mixed
     */
    protected function traverse(DOMNodeIterator $lhs, DOMNodeIterator $rhs)
    {
        while ($lhs->valid()) {
            $errors = $this->comparator->compare($lhs->current(), $rhs->current());
            if (count($errors) > 0) {
                $this->errors[] = $errors;
            }

            if ($lhs->hasChildren()) {
                if ($rhs->hasChildren()) {
                    $this->traverse($lhs->getChildren(), $rhs->getChildren());
                } else {
                    // How to get the error here
                    throw new \UnexpectedValueException('Missing nodes in other DOMDocument');
                }
            }

            $lhs->next();
            $rhs->next();
        }

        return $this->errors;
    }
}
