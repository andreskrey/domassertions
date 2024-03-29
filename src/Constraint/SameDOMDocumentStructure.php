<?php

declare(strict_types=1);

namespace andreskrey\PHPUnit\Constraint;

use andreskrey\PHPUnit\Comparator\ComparatorInterface;
use andreskrey\PHPUnit\Comparator\ComparisionErrorList;
use andreskrey\PHPUnit\Iterator\DOMNodeIterator;
use PHPUnit\Framework\Constraint\Constraint;

/**
 * Class SameDOMDocumentStructure.
 */
class SameDOMDocumentStructure extends Constraint
{
    /**
     * @var \DOMDocument
     */
    protected $original;

    /**
     * @var ComparatorInterface
     */
    protected $comparator;

    /**
     * @var ComparisionErrorList[]
     */
    protected $errors = [];

    /**
     * SameDOMDocumentStructure constructor.
     *
     * @param \DOMDocument        $document
     * @param ComparatorInterface $comparator
     */
    public function __construct(\DOMDocument $document, ComparatorInterface $comparator)
    {
        $this->original = $document;
        $this->comparator = $comparator;
    }

    /**
     * {@inheritdoc}
     */
    protected function matches($other): bool
    {
        $lhs = new DOMNodeIterator($this->original);
        $rhs = new DOMNodeIterator($other);

        return 0 === count($this->traverse($lhs, $rhs));
    }

    /**
     * {@inheritdoc}
     */
    public function toString(): string
    {
        return 'has same DOMDocument structure';
    }

    /**
     * {@inheritdoc}
     */
    protected function additionalFailureDescription($other): string
    {
        return 'Here goes the diff';
    }

    /**
     * @param DOMNodeIterator $lhs
     * @param DOMNodeIterator $rhs
     *
     * @return array List of discrepancies between Nodes, if any
     */
    protected function traverse(DOMNodeIterator $lhs, DOMNodeIterator $rhs)
    {
        while ($lhs->valid()) {
            $original = $lhs->current();
            $other = $rhs->current();
            $errors = $this->comparator->compare($original, $other);

            if (count($errors) > 0) {
                $this->errors[] = $errors;
            }

            if ($lhs->hasChildren()) {
                if ($rhs->hasChildren()) {
                    $this->traverse($lhs->getChildren(), $rhs->getChildren());
                } else {
                    $this->errors[] = $this->comparator->compare($original, null);
                }
            }

            $lhs->next();
            $rhs->next();
        }

        return $this->errors;
    }
}
