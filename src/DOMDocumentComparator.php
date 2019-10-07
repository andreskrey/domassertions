<?php

declare(strict_types=1);

namespace andreskrey\PHPUnit;

use andreskrey\PHPUnit\Comparator\ComparisionErrorList;
use andreskrey\PHPUnit\Constraint\SameDOMDocumentStructure;

class DOMDocumentComparator extends SameDOMDocumentStructure
{
    /**
     * @param mixed $other
     *
     * @return bool
     */
    public function matches($other): bool
    {
        return parent::matches($other);
    }

    /**
     * @return string
     */
    public function errorDifference(): string
    {
        return parent::additionalFailureDescription(null);
    }

    /**
     * @return ComparisionErrorList[]
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}
