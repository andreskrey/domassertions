<?php

declare(strict_types=1);

namespace andreskrey\PHPUnit\Comparator;

use andreskrey\PHPUnit\Comparator\Error\ComparisionErrorInterface;

/**
 * Class ComparisionErrorList.
 */
class ComparisionErrorList implements \Countable, \IteratorAggregate
{
    /**
     * @var ComparisionErrorInterface[]
     */
    protected $list = [];

    /**
     * @param ComparisionErrorInterface $error
     *
     * @return ComparisionErrorList
     */
    public function addComparisionError(ComparisionErrorInterface $error): self
    {
        $this->list[] = $error;

        return $this;
    }

    /**
     * @return array
     */
    public function getComparisionErrors(): array
    {
        return $this->list;
    }

    /**
     * {@inheritdoc}
     */
    public function count()
    {
        return count($this->list);
    }

    /**
     * {@inheritdoc}
     */
    public function getIterator(): \Generator
    {
        foreach ($this->list as $key => $error) {
            yield $key => $error;
        }
    }
}
