<?php
declare(strict_types=1);

namespace andreskrey\PHPUnit\Comparator;

use andreskrey\PHPUnit\Entity\ComparableEntity;

class NodeComparator
{
    public function compare(?\DOMNode $original, ?\DOMNode $other): bool
    {
        $original = $this->createEntity($original);
        $other = $this->createEntity($other);

        if (null === $original || null === $other) {
            return false;
        }

        return true;
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
}
