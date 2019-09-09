<?php
declare(strict_types=1);

namespace andreskrey\PHPUnit\Comparator;

use andreskrey\PHPUnit\Comparator\Error\NodeNameComparisionError;
use andreskrey\PHPUnit\Comparator\Error\NodeTypeComparisionError;
use andreskrey\PHPUnit\Comparator\Error\NodeContentComparisionError;
use andreskrey\PHPUnit\Comparator\Error\NodeAttributeComparisionError;

class NodeComparator
{
    public function compare(\DOMNode $original, \DOMNode $other): ComparisionErrorList
    {
        $name = $this->compareNodeName($original, $other);
        $type = $this->compareNodeType($original, $other);
        $content = $this->compareContent($original, $other);
        $attributes = $this->compareAttributes($original, $other);

        $list = new ComparisionErrorList();

        foreach (array_filter([$name, $type, $content, $attributes]) as $error) {
            $list->addComparisionError($error);
        }

        return $list;
    }

    protected function compareNodeName(\DOMNode $original, \DOMNode $other)
    {
        if ($original->nodeName !== $other->nodeName) {
            return new NodeNameComparisionError(
                $original,
                $other,
                sprintf('Different node name, original: "%s", other: "%s"', $original->nodeName, $other->nodeName)
            );
        }

        return null;
    }

    protected function compareNodeType(\DOMNode $original, \DOMNode $other)
    {
        if ($original->nodeType !== $other->nodeType) {
            return new NodeTypeComparisionError(
                $original,
                $other,
                sprintf('Different node type, original: "%s", other: "%s"', $original->nodeType, $other->nodeType)
            );
        }

        return null;
    }

    protected function compareContent(\DOMNode $original, \DOMNode $other)
    {
        if ($original->C14N() === $other->C14N()) {
            return new NodeContentComparisionError(
                $original,
                $other,
                sprintf('Different node content, original: "%s", other: "%s" (truncated)', substr($original->C14N(), 0, 256), substr($other->C14N(), 0, 256))
            );
        }

        return null;
    }

    protected function compareAttributes(\DOMNode $original, \DOMNode $other)
    {
        // TODO Fuck this shite for now
        return null;
        $lhs = $original->attributes;
        $rhs = $other->attributes;

        if (null === $lhs && null === $rhs) {
            return null;
        }

        // Could be optimized
        if ((null === $lhs && null !== $rhs) || (null !== $lhs && null === $rhs)) {
            return $this->getAttributeError($lhs, $rhs, sprintf('Different node attributes. One node has no attributes.'));
        }

        if ($lhs->length !== $rhs->length) {
            // TODO, be more specific?
            return $this->getAttributeError($lhs, $rhs, sprintf('Different node attributes. Nodes have a different amount of attributes.'));
        }

        for ($i = 0; $i < $lhs->length; $i++) {
            if ($lhs->item($i)->nodeName !== $rhs->item($i)->nodeName) {
                return false;
            }

            if ($lhs->item($i)->nodeValue !== $rhs->item($i)->nodeValue) {
                return false;
            }
        }

        return true;
    }

    protected function getAttributeError($original, $other, $error)
    {
        return new NodeAttributeComparisionError(
            $original,
            $other,
            $error
        );
    }
}
