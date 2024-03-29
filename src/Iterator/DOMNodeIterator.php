<?php

declare(strict_types=1);

namespace andreskrey\PHPUnit\Iterator;

class DOMNodeIterator implements \RecursiveIterator
{
    /**
     * @var \DOMNode
     */
    protected $node;

    protected $depth;

    protected $cursor = 0;

    public function __construct(\DOMNode $node, int $depth = 0)
    {
        $this->node = $node;
        $this->depth = $depth;
    }

    /**
     * {@inheritdoc}
     */
    public function current()
    {
        if ($this->valid()) {
            return $this->node->childNodes->item($this->cursor);
        }

        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function next(): void
    {
        $this->cursor++;
    }

    /**
     * {@inheritdoc}
     */
    public function hasChildren(): bool
    {
        if ($this->valid()) {
            $DOMNodeList = $this->current()->childNodes;

            return !is_null($DOMNodeList);
        }

        return false;
    }

    /**
     * Returns an iterator for the current entry.
     *
     * @see https://php.net/manual/en/recursiveiterator.getchildren.php
     *
     * @return \RecursiveIterator an iterator for the current entry
     *
     * @since 5.1.0
     */
    public function getChildren(): self
    {
        return new self($this->node->childNodes->item($this->cursor));
    }

    /**
     * {@inheritdoc}
     */
    public function key(): \DOMNode
    {
        return $this->node;
    }

    /**
     * {@inheritdoc}
     */
    public function valid(): bool
    {
        if ($this->node->childNodes->length > $this->cursor) {
            return true;
        }

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function rewind(): void
    {
        $this->cursor = 0;
    }

    /**
     * Based on the node path. Counting the number of forward slashes will give the depth of the node.
     *
     * @return int
     */
    public function getDepth(): int
    {
        $nodePath = $this->node->getNodePath();

        return substr_count($nodePath, '/') - 1;
    }
}
