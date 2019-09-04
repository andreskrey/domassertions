<?php
declare(strict_types=1);

namespace andreskrey\PHPUnit\Comparator;

use andreskrey\PHPUnit\Entity\ComparableEntity;

class NodeComparator
{
    public function compare(?ComparableEntity $original, ?ComparableEntity $other): bool
    {
        if (null === $original || null === $other) {
            return false;
        }

        return true;
    }
}
