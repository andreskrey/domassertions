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
        return $this->compareDocuments($this->original, $other);
    }

    /**
     * {@inheritDoc}
     */
    public function toString(): string
    {
        return 'has same DOMDocument structure';
    }

    protected function compareDocuments(\DOMDocument $original, \DOMDocument $other): bool
    {
        $lhs = new DOMNodeIterator($original);
        $rhs = new DOMNodeIterator($other);

        $result = $this->traverse($lhs, $rhs);
    }

    protected function traverse(DOMNodeIterator $lhs, DOMNodeIterator $rhs)
    {
        while ($lhs->valid()) {
            try {
                if (null === $rhs->current()) {
                    throw new \UnexpectedValueException();
                }

                $errors = $this->comparator->compare($lhs->current(), $rhs->current());
                if (count($errors) > 0) {
                    throw new \UnexpectedValueException('Found differences in nodes', 0, $errors);
                }

                if ($lhs->hasChildren()) {
                    if ($rhs->hasChildren()) {
                        $this->traverse($lhs->getChildren(), $rhs->getChildren());
                    } else {
                        throw new \UnexpectedValueException('Missing nodes in other DOMDocument');
                    }
                }
            } catch (\UnexpectedValueException $exception) {
//                $lhs->current()->setIsEqual(false);
            } catch (\Exception $exception) {
                throw $exception;
            } finally {
                $lhs->next();
                $rhs->next();
            }
        }
    }
}
