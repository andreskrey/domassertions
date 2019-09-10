<?php
declare(strict_types=1);

namespace andreskrey\PHPUnit\Comparator;

use andreskrey\PHPUnit\Comparator\Error\ComparisionErrorInterface;

/**
 * Class ComparisionErrorList
 * @package andreskrey\PHPUnit\Comparator\Error
 */
class ComparisionErrorList implements \Countable, \IteratorAggregate
{
    /**
     * @var ComparisionErrorInterface[]
     */
    protected $list = [];

    /**
     * @param ComparisionErrorInterface $error
     */
    public function addComparisionError(ComparisionErrorInterface $error): void
    {
        $this->list[] = $error;
    }

    /**
     * @return array
     */
    public function getComparisionErrors(): array
    {
        return $this->list;
    }

    /**
     * {@inheritDoc}
     */
    public function count()
    {
        return count($this->list);
    }

    /**
     * {@inheritDoc}
     */
    public function getIterator(): \Generator
    {
        foreach ($this->list as $key => $error) {
            yield $key => $error;
        }
    }
}
