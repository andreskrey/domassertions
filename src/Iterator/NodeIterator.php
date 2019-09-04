<?php
declare(strict_types=1);

namespace andreskrey\PHPUnit\Iterator;

use andreskrey\PHPUnit\Entity\ComparableEntity;

class NodeIterator implements \Iterator
{
    /**
     * @var \DOMNode $node
     */
    protected $node;

    protected $currentNode = null;

    protected $cursor = -1;

    public function __construct(\DOMNode $node)
    {
        $this->node = $node;
        $this->next();
    }

    protected function createEntity(\DOMNode $node): ComparableEntity
    {
        return new ComparableEntity(
            $node->nodeName,
            $node->nodeType,
            $node->C14N(),
            $node->attributes ? iterator_to_array($node->attributes) : []
        );
    }

    /**
     * {@inheritDoc}
     */
    public function current()
    {
        if ($this->currentNode) {
            return $this->currentNode;
        }

        throw new \OutOfBoundsException();
    }

    /**
     * {@inheritDoc}
     */
    public function next()
    {
        $this->cursor++;

        if (null === $this->node->childNodes) {
            return $this->currentNode = $this->createEntity($this->node);
        }

        if ($this->node->childNodes->length > $this->cursor) {
            return $this->currentNode = new self($this->node->childNodes->item($this->cursor));
        }

        $this->currentNode = null;
    }

    /**
     * {@inheritDoc}
     */
    public function key()
    {
        /*
         * Maybe inner position?
         * A
         * -B
         * --C
         * ---D0
         * ---D1
         * ---D2
         */
        return $this->cursor;
    }

    /**
     * {@inheritDoc}
     */
    public function valid()
    {
        return (bool)$this->currentNode;
    }

    /**
     * {@inheritDoc}
     */
    public function rewind()
    {
        $this->cursor = 0;
    }
}
